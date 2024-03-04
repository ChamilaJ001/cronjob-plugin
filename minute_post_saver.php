<?php
/*
Plugin Name: Minute Post Saver
Description: Saves a post every minute using a cron job.
Version: 1.0
Author: Chamila
*/


register_activation_hook(__FILE__, 'minute_post_saver_activate');

function minute_post_saver_activate()
{
    if (!wp_next_scheduled('minute_post_saver_cron')) {
        wp_schedule_event(time(), 'every_minute', 'minute_post_saver_cron');
    }
}

register_deactivation_hook(__FILE__, 'minute_post_saver_deactivate');

function minute_post_saver_deactivate()
{
    wp_clear_scheduled_hook('minute_post_saver_cron');
}

add_action('minute_post_saver_cron', 'minute_post_saver_cron_job');

function minute_post_saver_cron_job()
{
    $post_data = array(
        'post_title' => 'Cron Job Post - ' . date('Y-m-d H:i:s'),
        'post_content' => 'This post was created by a cron job.',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'post'
    );

    wp_insert_post($post_data);
}
