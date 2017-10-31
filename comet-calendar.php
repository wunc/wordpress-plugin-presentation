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
 * @param array $attributes The shortcode attributes
 * @return string
 */
function renderCometCalendarShortcode($attributes)
{
    $options = shortcode_atts([
        'feed_id' => '5021',
        // Comet Calendar JS API options
        'disable_link' => false,
        'title' => '',
        'contact_email' => '',
        'contact_name' => '',
        'z_location' => '',
        'contact_phone' => '',
        'description' => '',
        'img_loc' => '',
        'tags' => '',
        'website' => '',
        'time' => '',
    ], $attributes);

    $public_url = plugin_dir_url(__FILE__) . 'public';

    // Load Scripts
    wp_enqueue_script('utd_cometcalendar_js', 'https://www.utdallas.edu/calendar/api/apijq.php?n=' . $options['feed_id'], ['jquery'], '1.0.0');
    wp_register_script('cometcalendar_js', $public_url . '/js/cometcalendar.js', ['jquery', 'utd_cometcalendar_js'], '1.0.0');
    wp_localize_script('cometcalendar_js', 'cometcalendar_options', $options);
    wp_enqueue_script('cometcalendar_js');

    // Load Styles
    wp_enqueue_style('cometcalendar_css', $public_url . '/css/cometcalendar.css', [], '1.0.0');

    return '<div id="cc' . $options['feed_id'] . '" class="comet-calendar"></div>';
}
add_shortcode( 'comet-calendar', 'renderCometCalendarShortcode');
