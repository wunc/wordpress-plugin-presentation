<?php

// Autoload classes
spl_autoload_register(function($class_name) {
    $prefix = 'CometCalendarPlugin\\';
    $prefix_length = strlen($prefix);

    if (strncmp($prefix, $class_name, $prefix_length) !== 0) { // Only autoload CometCalendarPlugin classes
        return;
    }

    $relative_class = substr($class_name, $prefix_length);
    $filename = plugin_dir_path( __FILE__ ) . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($filename)) {
        include_once $filename;
    }
});