<?php

    /**
     * OMS Sidebar Content Widget
     *
     * THIS WIDGET IS CURRENTLY IN DEVELOPMENT AND SHOULD NOT APPEAR IN THE
     * WIDGET LIST. DO NOT TRY TO USE THIS WIDGET.
     *
     * @author Jimmy K. <jimmy@orbitmedia.com>
     * @link http://www.orbitmedia.com
     */

    class OMS_SidebarContentWidget extends OMS_SidebarWidget
    {

        /**
         * The constructor for this widget.
         *
         * @return void
         * @author Jimmy K.
         */

        public function __construct()
        {

            parent::__construct();

            // Set the plugin settings.
            $this->settings['namespace'] = 'oms_sw_content';

            // Set the options.
            $options = array(
                'classname' => 'OMS_SidebarContentWidget',
                'description' => 'An open content area widget. Raw HTML can be pasted into it and displayed in your sidebar.',
            );

            // Set the fields.
            $this->fields = array(
                'title' => '',
                'html' => '',
            );

            // Initialize the widget.
            $this->WP_Widget(
                'OMS_SidebarContentWidget',
                'OMS Content Widget',
                $options,
                array(
                    'width' => 500,
                )
            );

        }

        /**
         * Enqueue the scripts and styles.
         *
         * @return void
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        public function enqueue_print_scripts()
        {

            parent::enqueue_print_scripts();

            // STYLES
            wp_enqueue_style($this->settings['namespace'] . '_css', $this->settings['dir'] . '/css/oms-sw-content.css');

        }

        /**
         * Hook the form process.
         *
         * @return void
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        public function form($instance)
        {

            $instance = wp_parse_args(
                (array) $instance,
                $this->fields
            );

            // TITLE
            echo OMS_SidebarWidget::output_text_field(
                $instance,
                array(
                    'name' => 'title',
                    'label' => 'Title',
                )
            );

            // HTML
            echo OMS_SidebarWidget::output_textarea(
                $instance,
                array(
                    'name' => 'html',
                    'label' => 'HTML',
                    'rows' => 10,
                )
            );

        }

        /**
         * Format the output for this widget.
         *
         * @return string
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        public function output($args, $data)
        {

            // Markup WordPress adds before a widget.
            $return = $args['before_widget'];

            $return .= '
                <!-- sideBar_ElementHolder -->
                <div class="sideBar_ElementHolder sideBar_ContentElementHolder">
                    ' . $this->format_title($args, $data['title']) . '
                    <!-- sideBar_ContentHolder -->
                    <div class="sideBar_ContentHolder">
                        ' . $data['html'] . '
                    </div><!-- /sideBar_ContentHolder -->
                </div><!-- /sideBar_ElementHolder -->
                <div class="sideBar_Spacer"></div>
            ';

            // Markup WordPress adds after a widget.
            $return .= $args['after_widget'];

            return $return;

        }

    }
