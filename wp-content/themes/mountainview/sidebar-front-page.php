<?php

    if(is_active_sidebar('sidebar-6')):
        ?>
        <div class="front-page-top-sidebar">
            <div class="front-page-main-widget-area widget-area">
                <?php
                dynamic_sidebar('sidebar-6');
                ?>
            </div>
        </div>
    <?php
    endif;
    if(is_active_sidebar('sidebar-7') || is_active_sidebar('sidebar-8')):
        ?>
        <div class="front-page-bottom-sidebars">
            <?php
            if(is_active_sidebar('sidebar-7')):
                ?>
                <div class="front-page-bottom-left widget-area">
                    <?php
                    dynamic_sidebar('sidebar-7');
                    ?>
                </div>
            <?php

            endif;

            if(is_active_sidebar('sidebar-8')):
                ?>
                <div class="front-page-bottom-right widget-area">
                    <?php
                    dynamic_sidebar('sidebar-8');
                    ?>
                </div>
            <?php
            endif;
            ?>
        </div>
    <?php
    endif;