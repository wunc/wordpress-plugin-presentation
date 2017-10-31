<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area.
 * 
 * This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @wordpress-plugin
 * Plugin Name:       Comet Calendar
 * Plugin URI:        https://github.com/wunc/wordpress-plugin-presentation
 * Description:       Show a comet calendar feed via a shortcode.
 * Version:           1.0.0
 * Author:            Wun Chiou
 * Author URI:        https://www.wunchiou.com
 * License:           MIT
 * License URI:       http://opensource.org/licenses/MIT
 * Text Domain:       comet-calendar
 * Domain Path:       /languages
 */

/**
 * Renders the 'comet-calendar' shortcode.
 * 
 * @return string
 */
function renderCometCalendarShortcode()
{
    $feed_id = '5021';

    // Load Scripts
    wp_enqueue_script('utd_cometcalendar_js', 'https://www.utdallas.edu/calendar/api/apijq.php?n=' . $feed_id, ['jquery'], '1.0.0');

    return '<div id="cc' . $feed_id . '"></div>';
}
add_shortcode( 'comet-calendar', 'renderCometCalendarShortcode');
