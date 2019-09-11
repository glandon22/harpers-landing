<?php

namespace MPHB\iCal\BackgroundProcesses;

use \MPHB\Exceptions\NoEnoughExecutionTimeException;
use \MPHB\Exceptions\RequestException;
use \MPHB\iCal\ImportStatus;
use \MPHB\iCal\Stats;
use \MPHB\iCal\Queue;
use \MPHB\Libraries\WP_Background_Processing\WP_Background_Process;

abstract class BackgroundWorker extends WP_Background_Process {

	const BATCH_SIZE = 1000;

	const ACTION_PULL_URLS	 = 'pull-urls'; // Only for synchronization
	const ACTION_PARSE		 = 'parse';
	const ACTION_IMPORT		 = 'import';

	const MAX_REQUEST_TIMEOUT = 30; // 30 seconds

	/** @var string */
	protected $prefix = 'mphb_ical';

	/** @var \MPHB\iCal\Importer */
	protected $importer = null;

	/** @var \MPHB\iCal\Logger */
	protected $logger = null;

	/** @var \MPHB\iCal\Stats */
	protected $stats = null;

	/** @var \MPHB\iCal\OptionsHandler */
	protected $options = null;

	/** @var int */
	protected $maxExecutionTime = 0;

	public function __construct(){
		// Add blog ID to the prefix (only for multisites and only for IDs 2, 3 and so on)
		$blogId = get_current_blog_id();
		if ( $blogId > 1 ) {
			$this->prefix .= '_' . $blogId;
		}

		parent::__construct();

        // We'll need options to get current item from wp_option in
        // background-synchronizer.php
		$this->options = new \MPHB\iCal\OptionsHandler( $this->identifier );

        $currentItem = $this->getCurrentItem();
        $queueId = !empty($currentItem) ? Queue::findId($currentItem) : 0;

		$this->importer = new \MPHB\iCal\Importer();
		$this->logger   = new \MPHB\iCal\Logger($queueId);
		$this->stats	= new \MPHB\iCal\Stats($queueId);

		$this->maxExecutionTime = intval( ini_get( 'max_execution_time' ) );
	}

	/**
	 * @return bool
	 */
	public function isInProgress(){
		// The main check is is_queue_empty(). But we also need to check if the
		// process actually stopped (unlocked) - is_process_running()
		return $this->is_process_running() || !$this->is_queue_empty();
	}

	public function isAborting(){
		return $this->options->getOptionNoCache( 'abort_current', false );
	}

	public function touch(){
		if ( !$this->is_process_running() && !$this->is_queue_empty() ) {
			// Background process down, but was not finished. Restart it
			$this->dispatch();
		}
	}

	public function abort(){
		if ( $this->isInProgress() ) {
			$this->options->updateOption( 'abort_current', true );
		}
	}

    /**
     * Reset only before new start. On finish you'll reset the stats.
     */
	public function reset(){
		$this->clearOptions();

		$queueItem = $this->getCurrentItem();
        $queueId = Queue::findId($queueItem);

		$this->logger->setQueueId($queueId);
		$this->stats->setQueueId($queueId);

		if (!empty($queueId)) {
			Stats::resetStats($queueId);
		}
	}

    /**
     * Clear options on start and finish.
     */
    public function clearOptions()
    {
        $this->options->deleteOption('abort_current');
    }

	protected function complete(){
		parent::complete();

        $this->clearOptions();

		do_action( $this->identifier . '_complete' );
	}

	protected function timeLeft(){
		if ( $this->maxExecutionTime > 0 ) {
			return $this->start_time + $this->maxExecutionTime - time();
		} else {
			return self::MAX_REQUEST_TIMEOUT;
		}
	}

	public function getIdentifier(){
		return $this->identifier;
	}

    public function getOptions()
    {
        return $this->options;
    }

	public function getCurrentItem()
	{
		return '';
	}

    public function getProgress()
    {
        $stats = $this->stats->getStats();

        $total = $stats['total'];
        $processed = $stats['succeed'] + $stats['skipped'] + $stats['failed'];

        if ($total == 0) {
            return $this->isInProgress() ? 0 : 100;
        } else {
            return min(round($processed / $total * 100), 100);
        }
    }

	/**
	 * @param array $task ["action", "roomId", "calendarUri", "event"]. "calendarUri"
	 * only required for ACTION_PARSE action and "event" required only for ACTION_IMPORT
	 * action.
	 * @return array|false
	 */
	protected function task( $task ){
		// See the structure of all the tasks below, in methods add*Tasks()

		if ( $this->isAborting() ) {
			$this->cancel_process();
			return false;
		}

		if ( !isset( $task['action'] ) ) {
			return false;
		}

		switch ( $task['action'] ) {
			case self::ACTION_PARSE:
				$task = $this->taskParse( $task );
				break;
			case self::ACTION_IMPORT:
				$task = $this->taskImport( $task );
				break;
			case self::ACTION_PULL_URLS:
				$task = $this->taskPullUrls( $task );
				break;
		}

		return $task;
	}

	/**
	 * @param int $roomIds
	 */
	public function addPullUrlTask( $roomId ){
        $tasks = array(
            array(
                'action' => BackgroundWorker::ACTION_PULL_URLS,
                'roomId' => $roomId
            )
        );

		$this->addTasks( $tasks );
	}

	/**
	 * @param int $roomId
	 * @param string[] $calendarUris
	 */
	public function addParseTasks( $roomId, $calendarUris ){
		$tasks = array_map( function( $calendarUri ) use ( $roomId ) {
			return array(
				// Cannot access self:: in callback on PHP 5.3 (fatal error)
				'action'		 => BackgroundWorker::ACTION_PARSE,
				'roomId'		 => $roomId,
				'calendarUri'	 => $calendarUri
			);
		}, $calendarUris );

		$this->addTasks( $tasks );
	}

	/**
	 * @param int $roomId
	 * @param array $eventValues Array of [uid, checkIn, checkOut, summary, description].
	 *
	 * @see MPHB\iCal\iCal::parseEvent()
	 */
	public function addImportTasks( $roomId, $eventValues ){
		$tasks = array_map( function( $values ) use ( $roomId ) {
			return array(
				// Cannot access self:: in callback on PHP 5.3 (fatal error)
				'action' => BackgroundWorker::ACTION_IMPORT,
				'roomId' => $roomId,
				'event'	 => $values
			);
		}, $eventValues );

		$this->addTasks( $tasks );
	}

	/**
	 * @param array $tasks
	 */
	protected function addTasks( $tasks ){
		// Save new batches
		$batches = array_chunk( $tasks, self::BATCH_SIZE );

		foreach ( $batches as $batch ) {
			$this->data( $batch )->save();
		}

        $this->touch();
	}

	/**
	 * Mainly required for uploader: returns real file name instead of tmp name,
	 * like "/tmp/phpPRrGqo".
	 */
	abstract protected function retrieveCalendarNameFromSource( $calendarUri );

	/**
	 * @throws \MPHB\Exceptions\NoEnoughExecutionTimeException
	 * @throws \MPHB\Exceptions\RequestException
	 */
	abstract protected function retrieveCalendarContentFromSource( $calendarUri );

	/**
	 * @param array $task ["roomId", "calendarUri"].
	 * @return array|false
	 */
	protected function taskParse( $task ){
		$roomId			 = $task['roomId'];
		$calendarUri	 = $task['calendarUri'];
		$calendarName	 = $this->retrieveCalendarNameFromSource( $calendarUri );
		$logContext		 = array( 'roomId' => $roomId );

		try {
			/**
			 * @throws \MPHB\Exceptions\NoEnoughExecutionTimeException
			 * @throws \MPHB\Exceptions\RequestException
			 */
			$calendarContent = $this->retrieveCalendarContentFromSource( $calendarUri );
			/**
			 * @throws \Exception
			 */
			$ical			 = new \MPHB\iCal\iCal( $calendarContent );
			$eventValues	 = $ical->getEventsData( $roomId );
			$eventsCount	 = count( $eventValues );

			if ( $eventsCount > 0 ) {
				// This info can replace some messages from background process if log it after the process starts
				$message = sprintf( _nx( '%1$d event found in calendar %2$s', '%1$d events found in calendar %2$s', $eventsCount, '%s - calendar URI or calendar filename', 'motopress-hotel-booking' ), $eventsCount, $calendarName );
				$this->logger->info( $message, $logContext );

				$this->addImportTasks( $roomId, $eventValues );

				$this->stats->increaseTotal($eventsCount);

			} else {
				if ( empty( $calendarContent ) ) {
					$this->logger->warning( sprintf( _x( 'Calendar source is empty (%s)', '%s - calendar URI or calendar filename', 'motopress-hotel-booking' ), $calendarName ), $logContext );
				} else {
					$this->logger->warning( sprintf( _x( 'Calendar file is not empty, but there are no events in %s', '%s - calendar URI or calendar filename', 'motopress-hotel-booking' ), $calendarName ), $logContext );
				}
			}

		} catch ( NoEnoughExecutionTimeException $e ) {
			// Stop executing ACTION_PARSE taks, restart the process and give
			// more time to request files
			add_filter( $this->identifier . '_time_exceeded', '__return_true' );

			// Here can be problems on hosts with low max_execution_time:
			// - WP Background Processing library does not check the execution
			//   time option and always schedule 20 seconds for every handle
			//   cycle; so the process can fall and restart only by cron (only
			//   every 5 minutes);
			// - process can go into an infinite loop, restarting every time
			//   because of negative timeout.

			return $task;

		} catch ( RequestException $e ) {
			$this->logger->error( sprintf( __( 'Error while loading calendar (%1$s): %2$s', 'motopress-hotel-booking' ), $calendarUri, $e->getMessage() ), $logContext );
		} catch ( \Exception $e ) {
			$this->logger->error( sprintf( _x( 'Parse error. %s', '%s - error description', 'motopress-hotel-booking' ), $e->getMessage() ), $logContext );
		}

		return false;
	}

	/**
	 * @param array $task ["roomId", "event"].
	 * @return array|false
	 */
	protected function taskImport( $task ){
		$roomId		 = $task['roomId'];
		$eventValues = $task['event'];

		$importStatus = $this->importer->import( $roomId, $eventValues );

		switch ( $importStatus ){
			case ImportStatus::SUCCESS:
				$this->logger->success( $this->importer->getLastMessage(), $eventValues );
				$this->stats->increaseSucceed( 1 );
				break;

			case ImportStatus::SKIPPED:
				$this->logger->info( $this->importer->getLastMessage(), $eventValues );
				$this->stats->increaseSkipped( 1 );
				break;

			case ImportStatus::FAILED:
				$this->logger->error( $this->importer->getLastMessage(), $eventValues );
				$this->stats->increaseFailed( 1 );
				break;
		}

		return false;
	}

	abstract protected function taskPullUrls( $task );

}
