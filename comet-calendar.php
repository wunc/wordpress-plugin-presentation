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

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

require plugin_dir_path( __FILE__ ) . 'autoload.php';

/**
 * Initialize the Plugin.
 */
function initCometCalendarPlugin()
{
    (new CometCalendarPlugin\Shortcodes\CometCalendar())->register();
}
add_action('init', 'initCometCalendarPlugin');
