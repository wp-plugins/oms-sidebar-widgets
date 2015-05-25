<?php

    /**
     * Plugin Name: OMS Sidebar Widgets
     * Plugin URI: http://www.orbitmedia.com
     * Description: Basic sidebar widget functionality. Widgets include: Image, Video (YouTube, Vimeo), Content, Map (Google).
     * Author: Jimmy K. <jimmy@orbitmedia.com>
     * Author URI: http://www.orbitmedia.com
     * Version: 2.5
     */

    // Whether or not we're debugging.
    $debug = false;

    // Include the classes.
    require_once(dirname(__FILE__) . '/class/class.OMS_SidebarWidget.php');
    require_once(dirname(__FILE__) . '/class/class.OMS_SidebarImageWidget.php');
    require_once(dirname(__FILE__) . '/class/class.OMS_SidebarVideoWidget.php');
    require_once(dirname(__FILE__) . '/class/class.OMS_SidebarMapWidget.php');

    // Initialize the widgets.
    add_action('widgets_init', create_function('', 'return register_widget("OMS_SidebarImageWidget");'));
    add_action('widgets_init', create_function('', 'return register_widget("OMS_SidebarVideoWidget");'));
    add_action('widgets_init', create_function('', 'return register_widget("OMS_SidebarMapWidget");'));

    if ($debug) {
        // Content widget is still being developed.
        require_once(dirname(__FILE__) . '/class/class.OMS_SidebarContentWidget.php');
        add_action('widgets_init', create_function('', 'return register_widget("OMS_SidebarContentWidget");'));
    }
