<?php

    /**
     * OMS Sidebar Widget
     *
     * This class serves as the base class for any OMS Sidebar Widget. This
     * class is generic enough that it can be used for future widgets.
     *
     * @author Jimmy K. <jimmy@orbitmedia.com>
     * @link http://www.orbitmedia.com
     */

    class OMS_SidebarWidget extends WP_Widget
    {

        // Hold the settings.
        protected $settings = array();

        // Hold the fields.
        protected $fields = array();

        /**
         * The constructor for this widget.
         *
         * @return void
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        public function __construct()
        {

            global $pagenow;

            // Set the plugin settings.
            $this->settings['namespace'] = 'oms_sw';
            $this->settings['dir'] = plugins_url('/oms-sidebar-widgets');

            // Only enqueue CSS and JavaScript on the front-end and widgets page.
            if ($pagenow == 'index.php' || $pagenow == 'widgets.php') {
                // Enqueue the scripts and styles.
                add_action('wp_print_scripts', array($this, 'enqueue_print_scripts'));
            }

            // Only enqueue the media uploader on the widgets page.
            if ($pagenow == 'widgets.php') {
                // Enqueue the admin scripts (media uploader).
                add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
            }

        }

        /**
         * Enqueue the admin scripts.
         *
         * @return void
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        public function enqueue_admin_scripts()
        {

            // Enqueue WordPress' built-in media library.
            wp_enqueue_media();

        }

        /**
         * Enqueue the scripts and styles.
         *
         * @return void
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        public function enqueue_print_scripts()
        {

            // PRETTYPHOTO
            wp_enqueue_style('oms_sw_prettyphoto_css', $this->settings['dir'] . '/vendor/prettyPhoto/css/prettyPhoto.css');
            wp_register_script('oms_sw_prettyphoto_lib', $this->settings['dir'] . '/vendor/prettyPhoto/js/jquery.prettyPhoto.js');
            wp_enqueue_script('oms_sw_prettyphoto_lib');

            // SCRIPTS
            wp_register_script('oms_sw_scripts', $this->settings['dir'] . '/js/oms-sw.js');
            wp_enqueue_script('oms_sw_scripts');

            // STYLES
            wp_enqueue_style('oms_sw_css', $this->settings['dir'] . '/css/oms-sw.css');

        }

        /**
         * Hook the update process.
         *
         * @return array
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        public function update($new_instance, $old_instance)
        {

            return OMS_SidebarWidget::update_instance(
                $new_instance,
                $old_instance,
                $this->fields
            );

        }

        /**
         * Hook the widget output process.
         *
         * @return void
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        public function widget($args, $instance)
        {

            // Get a copy of the fields.
            $data = $this->fields;

            foreach ($data as $k => $v) {
                // Copy instance values to data array.
                $data[$k] = $instance[$k];
            }

            // Output the HTML.
            echo $this->output($args, $data);

        }

        /* ======================================== */
        /* Placeholder Methods
        /* ======================================== */

        public function form($instance) {}
        protected function output($args, $data) {}

        /* ======================================== */
        /* Form Methods
        /* ======================================== */

        /**
         * Update an instance using key/value pairs.
         *
         * @return array
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        protected function update_instance($new_instance, $old_instance, $fields)
        {

            $instance = $old_instance;

            foreach ($fields as $k => $v) {
                $instance[$k] = $new_instance[$k];
            }

            return $instance;

        }

        /**
         * Make a value safe for output.
         *
         * @return string
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        protected function safe($value)
        {

            $value = htmlentities($value);
            return $value;

        }

        /**
         * Output a text field. Used by the admin interface.
         *
         * @param $options
         * - name: The unique slug of the element. Ex: name
         * - class: The class of the element. Ex: widefat
         * - label: The title of the element. Ex: Title
         * - help_text: The help text to be displayed, if any. Ex: Please fill this out.
         * @return string
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        protected function output_text_field($instance, $options)
        {

            if (!is_array($options)) {
                return '';
            }

            if (!isset($options['class'])) {
                $options['class'] = 'widefat';
            }

            if (isset($options['help_text'])) {
                $options['help_text'] = '
                    <div class="help">' . $options['help_text'] . '</div>
                ';
            }

            $return = '
                <!-- ' . $options['name'] . ' -->
                <p class="' . $options['name'] . '">
                    <label for="' . $this->get_field_id($options['name']) . '">
                        ' . $options['label'] . ':
                    </label>
                    <input type="text" name="' . $this->get_field_name($options['name']) . '" id="' . $this->get_field_id($options['name']) . '" class="' . $options['class'] . ' ' . $options['name'] . '" value="' . attribute_escape($instance[$options['name']]) . '" />
                    ' . $options['help_text'] . '
                </p><!-- /' . $options['name'] . ' -->
            ';

            return $return;

        }

        /**
         * Output a text area. Used by the admin interface.
         *
         * @param $options
         * - name: The unique slug of the element. Ex: name
         * - rows: The number of rows for the element. Ex: 10
         * - cols: The number of columns for the element. Ex: 30
         * - class: The class of the element. Ex: widefat
         * - label: The title of the element. Ex: Title
         * - help_text: The help text to be displayed, if any. Ex: Please fill this out.
         * @return string
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        protected function output_textarea($instance, $options)
        {

            if (!is_array($options)) {
                return '';
            }

            if (!isset($options['class'])) {
                $options['class'] = 'widefat';
            }

            if (!isset($options['rows'])) {
                $options['rows'] = '10';
            }

            if (!isset($options['cols'])) {
                $options['cols'] = '30';
            }

            if (isset($options['help_text'])) {
                $options['help_text'] = '
                    <div class="help">' . $options['help_text'] . '</div>
                ';
            }

            $return = '
                <!-- ' . $options['name'] . ' -->
                <p class="' . $options['name'] . '">
                    <label for="' . $this->get_field_id($options['name']) . '">
                        ' . $options['label'] . ':
                    </label>
                    <textarea class="' . $options['class'] . ' ' . $options['name'] . '" rows="' . $options['rows'] . '" cols="' . $options['cols'] . '" id="' . $this->get_field_id($options['name']) . '" name="' .$this->get_field_name($options['name']) . '">' . attribute_escape($instance[$options['name']]) . '</textarea>
                </p><!-- /' . $options['name'] . ' -->
            ';

            return $return;

        }

        /**
         * Output an image select field. Used by the admin interface.
         *
         * @param $options
         * - name: The unique slug of the element. Ex: name
         * - class: The class of the element. Ex: widefat
         * - button_name: The unique slug of the button element. Ex: name_button
         * - button_class: The class of the button element. Ex: button
         * - label: The title of the element. Ex: Title
         * - help_text: The help text to be displayed, if any. Ex: Please fill this out.
         * @return string
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        protected function output_media_select_field($instance, $options)
        {

            if (!is_array($options)) {
                return '';
            }

            if (!isset($options['class'])) {
                $options['class'] = 'widefat';
            }

            if (!isset($options['button_text'])) {
                $options['button_text'] = 'Choose...';
            }

            if (isset($options['help_text'])) {
                $options['help_text'] = '
                    <div class="help">' . $options['help_text'] . '</div>
                ';
            }

            $return = '
                <!-- ' . $options['name'] . ' -->
                <p class="' . $options['name'] . '">
                    <label for="' . $this->get_field_id($options['name']) . '">
                        ' . $options['label'] . ':
                    </label>
                    <input type="text" name="' . $this->get_field_name($options['name']) . '" id="' . $this->get_field_id($options['name']) . '" class="' . $options['class'] . ' ' . $options['name'] . '" value="' . attribute_escape($instance[$options['name']]) . '" />
                    <input type="button" id="' . $this->get_field_id($options['button_name']) . '" class="oms_sw_media_select_button button ' . $options['button_class'] . '" value="' . $options['button_text'] . '" data-textfield-id="' . $this->get_field_id($options['name']) . '" />
                    ' . $options['help_text'] . '
                </p><!-- /' . $options['name'] . ' -->
            ';

            return $return;

        }

        /* ======================================== */
        /* Format Methods
        /* ======================================== */

        /**
         * Format the title of a widget.
         *
         * @param array $args
         * @param string $value
         * @return string
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        protected function format_title($args, $value)
        {

            if (!empty($value)) {
                return $args['before_title'] . apply_filters('widget_title', $this->safe($value)) . $args['after_title'];
            }

            return '';

        }

    }
