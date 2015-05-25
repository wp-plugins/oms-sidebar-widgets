<?php

    /**
     * OMS Sidebar Image Widget
     *
     * @author Jimmy K. <jimmy@orbitmedia.com>
     * @link http://www.orbitmedia.com
     */

    class OMS_SidebarImageWidget extends OMS_SidebarWidget
    {

        /**
         * The constructor for this widget.
         *
         * @return void
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        public function __construct()
        {

            parent::__construct();

            // Set the plugin settings.
            $this->settings['namespace'] = 'oms_sw_image';

            // Set the options.
            $options = array(
                'classname' => 'OMS_SidebarImageWidget',
                'description' => 'An image widget. Images open in a prettyPhoto lightbox when clicked.',
            );

            // Set the fields.
            $this->fields = array(
                'title' => '',
                'thumbnail_image' => '',
                'full_image' => '',
                'caption' => '',
            );

            // Initialize the widget.
            $this->WP_Widget(
                'OMS_SidebarImageWidget',
                'OMS Image Widget',
                $options
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
            wp_enqueue_style($this->settings['namespace'] . '_css', $this->settings['dir'] . '/css/oms-sw-image.css');

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

            // THUMBNAIL IMAGE
            echo OMS_SidebarWidget::output_media_select_field(
                $instance,
                array(
                    'name' => 'thumbnail_image',
                    'button_name' => 'thumbnail_image_button',
                    'button_class' => 'thumbnail_image_button',
                    'label' => 'Thumbnail Image',
                )
            );

            // FULL IMAGE
            echo OMS_SidebarWidget::output_media_select_field(
                $instance,
                array(
                    'name' => 'full_image',
                    'button_name' => 'full_image_button',
                    'button_class' => 'full_image_button',
                    'label' => 'Full Image',
                )
            );

            // CAPTION
            echo OMS_SidebarWidget::output_textarea(
                $instance,
                array(
                    'name' => 'caption',
                    'label' => 'Caption',
                    'rows' => 5,
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

            if (empty($data['thumbnail_image'])) {
                // Return nothing if an image hasn't been selected.
                return '';
            }

            // Markup WordPress adds before a widget.
            $return = $args['before_widget'];

            $return .= '
                <!-- sideBar_ElementHolder -->
                <div class="sideBar_ElementHolder sideBar_ImageElementHolder">
            ';

            /* ======================================== */
            /* Title
            /* ======================================== */

            if (!empty($data['title'])) {
                $return .= $this->format_title($args, $data['title']);
            }

            if (!empty($data['thumbnail_image'])) {

                /* ======================================== */
                /* Thumbnail
                /* ======================================== */

                $thumbnail_image = '
                    <img src="' . $data['thumbnail_image'] . '" alt="Image" />
                ';

                if (!empty($data['full_image'])) {

                    $thumbnail_image = '
                        <a href="' . $data['full_image'] . '" rel="prettyPhoto" title="' . htmlentities($data['caption']) . '">
                            ' . $thumbnail_image . '
                        </a>
                    ';

                }

                /* ======================================== */
                /* Caption
                /* ======================================== */

                $caption = '';

                if (!empty($data['caption'])) {

                    $caption = '
                        <!-- sideBar_Caption -->
                        <div class="sideBar_Caption">
                            ' . $data['caption'] . '
                        </div><!-- /sideBar_Caption -->
                    ';

                }

                /* ======================================== */
                /* Combined
                /* ======================================== */

                $return .= '
                    <!-- sideBar_ImageHolder -->
                    <div class="sideBar_ImageHolder">
                        ' . $thumbnail_image . '
                        ' . $caption . '
                    </div><!-- /sideBar_ImageHolder -->
                ';

            }

            $return .= '
                </div><!-- /sideBar_ElementHolder -->
                <div class="sideBar_Spacer"></div>
            ';

            // Markup WordPress adds after a widget.
            $return .= $args['after_widget'];

            return $return;

        }

    }
