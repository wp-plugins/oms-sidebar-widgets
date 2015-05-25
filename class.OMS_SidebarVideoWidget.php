<?php

    /**
     * OMS Sidebar Video Widget
     *
     * @author Jimmy K. <jimmy@orbitmedia.com>
     * @link http://www.orbitmedia.com
     */

    class OMS_SidebarVideoWidget extends OMS_SidebarWidget
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
            $this->settings['namespace'] = 'oms_sw_video';

            // Set the options.
            $options = array(
                'classname' => 'OMS_SidebarVideoWidget',
                'description' => 'A video widget. Videos play in a prettyPhoto lightbox when clicked. Supported video types are YouTube and Vimeo.',
            );

            // Set the fields.
            $this->fields = array(
                'title' => '',
                'thumbnail_image' => '',
                'video_url' => '',
                'caption' => '',
                'length' => '',
            );

            // Initialize the widget.
            $this->WP_Widget(
                'OMS_SidebarVideoWidget',
                'OMS Video Widget',
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
            wp_enqueue_style($this->settings['namespace'] . '_css', $this->settings['dir'] . '/css/oms-sw-video.css');

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

            // VIDEO URL
            echo OMS_SidebarWidget::output_text_field(
                $instance,
                array(
                    'name' => 'video_url',
                    'label' => 'YouTube/Vimeo URL',
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

            // LENGTH
            echo OMS_SidebarWidget::output_text_field(
                $instance,
                array(
                    'name' => 'length',
                    'label' => 'Length',
                    'help_text' => 'The length of this video in HH:MM:SS format.',
                )
            );

        }

        /**
         * Hook the widget process.
         *
         * @return void
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        public function widget($args, $instance)
        {

            // TITLE
            $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

            $data = array(
                'title' => str_replace('"', '&quot;', $title),
                'caption' => str_replace('"', '&quot;', $instance['caption']),
                'thumbnail_image' => str_replace('"', '&quot;', $instance['thumbnail_image']),
                'video_url' => str_replace('"', '&quot;', $instance['video_url']),
                'length' => str_replace('"', '&quot;', $instance['length']),
            );

            echo $this->output($args, $data);

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
                <div class="sideBar_ElementHolder sideBar_VideoElementHolder">
            ';

            /* ======================================== */
            /* Title
            /* ======================================== */

            if (!empty($data['title'])) {
                $return .= $this->format_title($args, $data['title']);
            }

            if (!empty($data['thumbnail_image'])) {

                /* ======================================== */
                /* Length
                /* ======================================== */

                $length = '';

                if (!empty($data['length'])) {

                    $length = '
                        <span class="length">(' . $data['length'] . ')</span>
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
                            ' . $length . '
                        </div><!-- /sideBar_Caption -->
                    ';

                }

                /* ======================================== */
                /* Thumbnail
                /* ======================================== */

                $thumbnail_image = '
                    <img src="' . $data['thumbnail_image'] . '" alt="Image" />
                ';

                if (!empty($data['video_url'])) {

                    $thumbnail_image = '
                        <a href="' . $data['video_url'] . '" rel="prettyPhoto" title="' . htmlentities($data['caption']) . '">
                            ' . $thumbnail_image . '
                        </a>
                    ';

                }

                /* ======================================== */
                /* Combined
                /* ======================================== */

                $return .= '
                    <!-- sideBar_VideoHolder -->
                    <div class="sideBar_VideoHolder">
                        <!-- sideBar_VideoHolderInner -->
                        <div class="sideBar_VideoHolderInner">
                            <!-- sideBar_VideoInner -->
                            <div class="sideBar_VideoInner">
                                <a href="' . $data['video_url'] . '" title="' . htmlentities($data['caption']) . '" rel="prettyPhoto">
                                    <div class="sideBar_PlayImage"></div>
                                </a>
                                ' . $thumbnail_image . '
                            </div><!-- sideBar_VideoInner -->
                            ' . $caption . '
                        </div><!-- /sideBar_VideoHolderInner -->
                    </div><!-- /sideBar_VideoHolder -->
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
