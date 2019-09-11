<?php

namespace MPHB\iCal;

class Stats
{
    const TABLE_NAME = 'mphb_sync_stats';

	/** @var int */
	protected $queueId = 0;

    /** @var string Table name. */
    protected $mphb_sync_stats = '';

	public function __construct( $queueId = 0 ){
        global $wpdb;

		$this->queueId = $queueId;
        $this->mphb_sync_stats = $wpdb->prefix . self::TABLE_NAME;
	}

	public function setQueueId( $queueId ){
		$this->queueId = $queueId;
	}

	public function getQueueId()
	{
		return $this->queueId;
	}

	public function increaseTotal($increment)
	{
		$this->increaseField('total', $increment);
	}

	public function increaseSucceed($increment)
	{
		$this->increaseField('succeed', $increment);
	}

	public function increaseSkipped($increment)
	{
		$this->increaseField('skipped', $increment);
	}

	public function increaseFailed($increment)
	{
        $this->increaseField('failed', $increment);
	}

    protected function increaseField($field, $increment)
    {
        global $wpdb;

        if (empty($this->queueId)) {
            return;
        }

        $query = $wpdb->prepare(
            "UPDATE {$this->mphb_sync_stats}"
                . " SET stat_{$field} = stat_{$field} + %d"
                . " WHERE queue_id = %d",
            $increment,
            $this->queueId
        );

        $wpdb->query($query);
    }

    public function getStats()
    {
        global $wpdb;

        $query = $wpdb->prepare(
            "SELECT stat_total, stat_succeed, stat_skipped, stat_failed"
                . " FROM {$this->mphb_sync_stats}"
                . " WHERE queue_id = %d", $this->queueId
        );

        $row = $wpdb->get_row($query, ARRAY_A);

        if (!is_null($row)) {
            return array(
                'total'   => $row['stat_total'],
                'succeed' => $row['stat_succeed'],
                'skipped' => $row['stat_skipped'],
                'failed'  => $row['stat_failed']
            );
        } else {
            return Stats::emptyStats();
        }
    }

    protected static function emptyStats()
    {
        return array(
            'total'   => 0,
            'succeed' => 0,
            'skipped' => 0,
            'failed'  => 0
        );
    }

    /**
     * @global \wpdb $wpdb
     *
     * @param int[] $queueIds
     * @return array [%Queue ID% => ["stat_total", ...]]
     */
	public static function selectStats($queueIds)
	{
		global $wpdb;

        if (empty($queueIds)) {
            return array();
        }

        $mphb_sync_stats = $wpdb->prefix . Stats::TABLE_NAME;

		$query = "SELECT queue_id, stat_total, stat_succeed, stat_skipped, stat_failed"
            . " FROM {$mphb_sync_stats}"
            . " WHERE queue_id IN (" . implode(", ", $queueIds) . ")";

        $rows = $wpdb->get_results($query, ARRAY_A);

        // Convert $rows array into [%Queue ID% => ["stat_total", ...]]
        $stats = array();

        foreach ($rows as $row) {
            $id = (int)$row['queue_id'];
            unset($row['queue_id']); // Leave only stats

            $stats[$id] = array_map('absint', $row); // Convert all values to int
        }

        // Use empty values for unexistant IDs
        $emptyStats = Stats::emptyStats();

        $results = array();

        foreach ($queueIds as $queueId) {
            if (isset($stats[$queueId])) {
                $results[$queueId] = array(
                    'total'   => $stats[$queueId]['stat_total'],
                    'succeed' => $stats[$queueId]['stat_succeed'],
                    'skipped' => $stats[$queueId]['stat_skipped'],
                    'failed'  => $stats[$queueId]['stat_failed']
                );
            } else {
                $results[$queueId] = $emptyStats;
            }
        }

        return $results;
	}

    /**
     * @param int $queueId
     *
     * @global \wpdb $wpdb
     */
	public static function resetStats($queueId)
	{
		global $wpdb;

		$resetValues  = array(
            'queue_id'     => $queueId,
            'stat_total'   => 0,
            'stat_succeed' => 0,
            'stat_skipped' => 0,
            'stat_failed'  => 0
        );

        $formatValues = array(
            '%d',
            '%d',
            '%d',
            '%d',
            '%d'
        );

        $where = array('queue_id' => $queueId);

        $mphb_sync_stats = $wpdb->prefix . Stats::TABLE_NAME;

        $itemExists = (bool)$wpdb->get_var($wpdb->prepare(
            "SELECT stat_id"
                . " FROM {$mphb_sync_stats}"
                . " WHERE queue_id = %d",
            $queueId
        ));

        if ($itemExists) {
            $wpdb->update($mphb_sync_stats, $resetValues, $where, $formatValues);
        } else {
            $wpdb->insert($mphb_sync_stats, $resetValues, $formatValues);
        }
	}

	/**
	 * @param int $queueId
	 *
	 * @global \wpdb $wpdb
	 */
	public static function deleteQueue($queueId)
	{
		global $wpdb;

        $mphb_sync_stats = $wpdb->prefix . Stats::TABLE_NAME;

		$query = $wpdb->prepare(
            "DELETE FROM {$mphb_sync_stats}"
                . " WHERE queue_id = %d",
            $queueId
        );

		$wpdb->query($query);
	}

    /**
     * Delete all stats, where queue status is "wait", "in-progress" or "done",
     * but leave stats of the "auto"-items.
     *
     * @global \wpdb $wpdb
     */
	public static function deleteSync()
	{
		global $wpdb;

        $mphb_sync_stats = $wpdb->prefix . Stats::TABLE_NAME;
        $mphb_sync_queue = $wpdb->prefix . Queue::TABLE_NAME;

        $query = $wpdb->prepare(
            "DELETE stats FROM {$mphb_sync_stats} AS stats"
                . " INNER JOIN {$mphb_sync_queue} AS queue ON stats.queue_id = queue.queue_id"
                . " WHERE queue.queue_status != %s",
            Queue::STATUS_AUTO
        );

		$wpdb->query($query);
	}
}
