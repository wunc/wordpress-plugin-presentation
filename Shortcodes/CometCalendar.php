<?php

namespace CometCalendarPlugin\Shortcodes;

class CometCalendar
{
    /** @var string Shortcode name */
    public $name = 'comet-calendar';

    /** @var array Shortcode attributes */
    public $attributes;

    /** @var array Shortcode default attributes */
    public $default_attributes = [
        'feed_id' => '5021',
        'year' => null,
        'limit' => 1000,
        'limit_showing' => 'earliest',
        'order' => 'asc',
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
    ];

    /** @var string The public URL to the shortcode's assets */
    public $public_url;

    /** @var string The path to the shortcode's view files */
    public $view_dir;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->view_dir = plugin_dir_path(dirname(__FILE__)) . 'Views';
        $this->public_url = plugin_dir_url(dirname(__FILE__)) . 'public';
    }

    /**
     * Registers this shortcode with WordPress
     */
    public function register()
    {
        add_shortcode($this->name, [$this, 'render']);
    }

    /**
     * Renders the shortcode.
     *
     * @param array $attributes The shortcode attributes
     * @return string
     */
    public function render($attributes)
    {
        $this->setAttributes($attributes);
        $this->loadAssets();

        return $this->view();
    }

    /**
     * Set the shortcode attributes.
     * 
     * @param  array $attributes
     */
    protected function setAttributes($attributes)
    {
        $this->attributes = shortcode_atts($this->default_attributes, $attributes);
    }

    /**
     * Load assets needed.
     */
    protected function loadAssets()
    {
        // Load Scripts
        wp_enqueue_script('utd_cometcalendar_js', 'https://www.utdallas.edu/calendar/api/apijq.php?n=' . $this->attributes['feed_id'], ['jquery'], '1.0.0');
        wp_register_script('cometcalendar_js', $this->public_url . '/js/cometcalendar.js', ['jquery', 'utd_cometcalendar_js'], '1.0.0');
        wp_localize_script('cometcalendar_js', 'cometcalendar_options', $this->attributes);
        wp_enqueue_script('cometcalendar_js');

        // Load Styles
        wp_enqueue_style('cometcalendar_css', $this->public_url . '/css/cometcalendar.css', [], '1.0.0');
    }

    /**
     * Get the view.
     * 
     * @return string
     */
    protected function view()
    {
        ob_start();

        // If the theme has a template-parts/content-cometcalendar.php file, use that to render.
        // Otherwise, use the default view partial included in this plugin.
        if (locate_template('template-parts/content-cometcalendar.php')) {
            set_query_var('options', $this->attributes); // pass $options to the template
            get_template_part('template-parts/content', 'cometcalendar');
        } else {
            $options = $this->attributes;
            include($this->view_dir . '/content-cometcalendar.php');
        }

        return ob_get_clean();
    }
}