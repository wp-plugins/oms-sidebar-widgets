<?php

    /**
     * OMS Sidebar Map Widget
     *
     * @author Jimmy K. <jimmy@orbitmedia.com>
     * @link http://www.orbitmedia.com
     */

    class OMS_SidebarMapWidget extends OMS_SidebarWidget
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
            $this->settings['namespace'] = 'oms_sw_map';

            // Set the options.
            $options = array(
                'classname' => 'OMS_SidebarMapWidget',
                'description' => 'A Google Maps widget. Locations can be automatically geocoded using the Google Maps API.',
            );

            // Set the fields.
            $this->fields = array(
                'json' => '', // Used to store the location data.
                'title' => '',
                'marker_image' => '',
            );

            // Initialize the widget.
            $this->WP_Widget(
                'OMS_SidebarMapWidget',
                'OMS Map Widget',
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

            // SCRIPTS
            wp_register_script($this->settings['namespace'] . '_js', $this->settings['dir'] . '/js/oms-sw-map.js');
            wp_enqueue_script($this->settings['namespace'] . '_js');
            wp_register_script($this->settings['namespace'] . '_google_maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false');
            wp_enqueue_script($this->settings['namespace'] . '_google_maps');

            // STYLES
            wp_enqueue_style($this->settings['namespace'] . '_css', $this->settings['dir'] . '/css/oms-sw-map.css');

        }

        /**
         * Hook the form process.
         *
         * @return void
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        public function form($instance)
        {

            // Generate a unique id for this form.
            $unique_id = rand(0, 9999);

            // Get the instance.
            $instance = wp_parse_args(
                (array) $instance,
                $this->fields
            );

            echo '
                <!-- oms-sw-map-form-container -->
                <div id="oms-sw-map-form-' . $unique_id . '" class="oms-sw-map-form-container">
            ';

            // JSON
            echo OMS_SidebarWidget::output_textarea(
                $instance,
                array(
                    'name' => 'json',
                    'label' => 'JSON',
                )
            );

            // TITLE
            echo OMS_SidebarWidget::output_text_field(
                $instance,
                array(
                    'name' => 'title',
                    'label' => 'Title',
                )
            );

            // MARKER IMAGE
            echo OMS_SidebarWidget::output_media_select_field(
                $instance,
                array(
                    'name' => 'marker_image',
                    'button_name' => 'marker_image_button',
                    'button_class' => 'marker_image_button',
                    'label' => 'Marker Image',
                    'help_text' => 'Optional. If a custom marker isn\'t specified then the default one will be used.',
                )
            );

            echo '
                <!-- repeatableContainer -->
                <div id="oms-sw-map-repeatable-container-' . $unique_id . '" class="repeatableContainer oms-sw-map-repeatable-container">
            ';

            if (!empty($instance['json'])) {
                // Parse the JSON object.
                $json = json_decode($instance['json']);
            } else {
                // Create an empty JSON object.
                $json = array(
                    array(
                        name => '',
                        address_1 => '',
                        address_2 => '',
                        city => '',
                        state => '',
                        zip => '',
                        country => '',
                        lat => '',
                        lng => '',
                        email => '',
                        phone => '',
                        fax => '',
                    ),
                );
            }

            // Hold the index.
            $i = 0;

            foreach ($json as $v) {

                echo '
                    <fieldset class="repeatable ' . ($i++ == 0 ? 'original' : '') . '">
                        <legend>Location</legend>
                ';

                // NAME
                echo '
                    <p class="name">
                        <label>Name:</label>
                        <input type="text" name="name" class="widefat name" value="' . $v->name . '" />
                    </p>
                ';

                // ADDRESS 1
                echo '
                    <p class="address_1">
                        <label>Address 1:</label>
                        <input type="text" name="address_1" class="widefat address_1" value="' . $v->address_1 . '" />
                    </p>
                ';

                // ADDRESS 2
                echo '
                    <p class="address_2">
                        <label>Address 2:</label>
                        <input type="text" name="address_2" class="widefat address_2" value="' . $v->address_2 . '" />
                    </p>
                ';

                // CITY
                echo '
                    <p class="city">
                        <label>City:</label>
                        <input type="text" name="city" class="widefat city" value="' . $v->city . '" />
                    </p>
                ';

                // STATE
                echo '
                    <p class="state">
                        <label>State:</label>
                        <input type="text" name="state" class="widefat state" value="' . $v->state . '" />
                    </p>
                ';

                // ZIP
                echo '
                    <p class="zip_code">
                        <label>Zip Code:</label>
                        <input type="text" name="zip_code" class="widefat zip_code" value="' . $v->zip_code . '" />
                    </p>
                ';

                // COUNTRY
                echo '
                    <p class="country">
                        <label>Country:</label>
                        <input type="text" name="country" class="widefat country" value="' . $v->country . '" />
                    </p>
                ';

                // LATITUDE
                echo '
                    <p class="lat">
                        <label>Latitude:</label>
                        <input type="text" name="lat" class="widefat lat" value="' . $v->lat . '" />
                        <div class="help">Leave blank to automatically geocode.</div>
                    </p>
                ';

                // LONGITUDE
                echo '
                    <p class="lng">
                        <label>Longitude:</label>
                        <input type="text" name="lng" class="widefat lng" value="' . $v->lng . '" />
                        <div class="help">Leave blank to automatically geocode.</div>
                    </p>
                ';

                // EMAIL
                echo '
                    <p class="email">
                        <label>Email:</label>
                        <input type="text" name="email" class="widefat email" value="' . $v->email . '" />
                    </p>
                ';

                // PHONE
                echo '
                    <p class="phone">
                        <label>Phone:</label>
                        <input type="text" name="phone" class="widefat phone" value="' . $v->phone . '" />
                    </p>
                ';

                // FAX
                echo '
                    <p class="fax">
                        <label>Fax:</label>
                        <input type="text" name="fax" class="widefat fax" value="' . $v->fax. '" />
                    </p>
                ';

                echo '
                        <input type="button" value="Remove Location" class="oms-sw-map-remove-location widefat button button-primary" onclick="oms_sw_map_remove_fieldset(this, ' . $unique_id . ');" />
                    </fieldset>
                ';

            }

            echo '
                    </div><!-- /repeatableContainer -->
                    <input type="button" value="+ Add Location" class="oms-sw-map-add-location widefat button" onclick="oms_sw_map_add_fieldset(this, ' . $unique_id . ');" />
                </div><!-- /oms-sw-map-form-container -->
            ';

        }

        /**
         * Hook the widget process.
         *
         * @return void
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        public function widget($args, $instance)
        {

            /* ======================================== */
            /* Marker Image
            /* ======================================== */

            // Default marker width and height.
            $marker_width = 30;
            $marker_height = 40;

            if (empty($instance['marker_image'])) {

                // Use the default marker image.
                $instance['marker_image'] = plugins_url('/oms-sidebar-widgets/images/markers/default.png');

            } else {

                if (!defined('ABSPATH')) {
                    // Get the absolute path of the WordPress installation.
                    define('ABSPATH', dirname(__FILE__) . '/');
                }

                // Extract the marker image filename.
                $marker_image_path = $instance['marker_image'];
                $marker_image_path = substr($marker_image_path, strpos($marker_image_path, '/wp-content/uploads/') + 1);

                if (@file_exists(ABSPATH . $marker_image_path)) {
                    // Get the width and height of the marker..
                    list($marker_width, $marker_height, $image_type, $image_attributes) = @getimagesize(ABSPATH . $marker_image_path);
                } else {
                    // echo 'Marker image does not exist.';
                }

            }

            /* ======================================== */
            /* Data Attributes
            /* ======================================== */

            // Data attributes will be used by jQuery to initialize the map.
            $instance_attributes = array(
                'marker_image_url' => $instance['marker_image'],
                'marker_image_width' => $marker_width,
                'marker_image_height' => $marker_height,
                'zoom_level' => 15, /* Temporarily hard-coded for WordPress. */
            );

            // Convert data attributes array to HTML attributes.
            foreach ($instance_attributes as $k => $v) {
                $data_attributes .= ' data-' . $this->safe($k) . '="' . $this->safe($v) . '"';
            }

            // Set the attributes.
            $instance['attributes'] = $data_attributes;

            /* ======================================== */
            /* Output
            /* ======================================== */

            echo $this->output($args, $instance);

        }

        /**
         * Format the output for this widget.
         *
         * @return string
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        public function output($args, $instance)
        {

            // Markup WordPress adds before a widget.
            $return = $args['before_widget'];

            // Parse the JSON.
            $json = json_decode($instance['json']);

            // Hold the formatted output.
            $formatted_html = '';

            // Hold the index.
            $i = 0;

            foreach ($json as $v) {

                /* ======================================== */
                /* Latitude & Longitude
                /* ======================================== */

                // Get the latitude and longitude.
                $lat = $v->lat;
                $lng = $v->lng;

                if ($lat == '0' || empty($lat) || $lng == '0' || empty($lng)) {

                    // Ask Google to geocode the address for us.
                    $geocoded_lat_lng = $this->geocode_address(
                        $v->address_1 . ' ' . $v->city . ', ' . $v->state . ', ' . $v->zip_code . ', ' . $v->country
                    );

                    if ($geocoded_lat_lng !== false) {
                        // Use the geocoded latitude and longitude instead.
                        $lat = $geocoded_lat_lng['lat'];
                        $lng = $geocoded_lat_lng['lng'];
                    }

                }

                // Set the data attributes.
                $instance_attributes = array(
                    'lat' => $lat,
                    'lng' => $lng,
                    'map_id' => rand(0, 999),
                );

                // Hold the data attributes output.
                $instance_attributes_html = '';

                // Convert data attributes array to HTML attributes.
                foreach ($instance_attributes as $instance_key => $instance_value) {
                    $instance_attributes_html .= ' data-' . $this->safe($instance_key) . '="' . $this->safe($instance_value) . '"';
                }

                $formatted_html .= '
                    <!-- sideBar_MapListAddress -->
                    <div class="sideBar_MapListAddress" ' . $instance_attributes_html . '>
                ';

                /* ======================================== */
                /* Formatted Address
                /* ======================================== */

                $formatted_html .= '
                    <!-- nameText -->
                    <div class="sideBar_MapAddressElement nameText" id="sideBar_ClickableElement_' . $instance_attributes['map_id'] . '">
                        <strong>' . $this->safe($v->name) . '</strong>
                    </div><!-- /nameText -->
                    <!-- combinedAddressText -->
                    <div class="sideBar_MapAddressElement addressText1">
                        ' . $this->safe($v->address_1) . '
                    </div><!-- /combinedAddressText -->
                    <!-- combinedAddressText -->
                    <div class="sideBar_MapAddressElement addressText2">
                        ' . $this->safe($v->address_2) . '
                    </div><!-- /combinedAddressText -->
                    <!-- cityStateZipText -->
                    <div class="sideBar_MapAddressElement cityStateZipText">
                        ' . $this->format_city_state_zip($v) . '
                    </div><!-- /cityStateZipText -->
                    <!-- directionsText -->
                    <div class="sideBar_MapAddressElement directionsText desktopOnly">
                        <a href="' . $this->format_directions_url($v) . '" target="_blank">Driving Directions</a>
                    </div><!-- /directionsText -->
                    <!-- directionsButton -->
                    <div class="sideBar_MapAddressElement directionsButton mobileOnly">
                        <a href="' . $this->format_directions_url($v) . '" class="button" target="_blank">Get Directions</a>
                    </div><!-- /directionsButton -->
                ';

                /* ======================================== */
                /* Formatted Phone
                /* ======================================== */

                if (!empty($v->phone)) {
                    $formatted_html .= '
                        <!-- phoneText -->
                        <div class="sideBar_MapAddressElement phoneText desktopOnly">
                            <strong>Phone:</strong> ' . $this->safe($v->phone) . '
                        </div><!-- /phoneText -->
                        <!-- phoneText -->
                        <div class="sideBar_MapAddressElement phoneText mobileOnly">
                            <a href="tel://' . $this->safe($v->phone) . '" class="button">Call Now</a>
                        </div><!-- /phoneText -->
                    ';
                }

                /* ======================================== */
                /* Formatted Fax
                /* ======================================== */

                if (!empty($v->fax)) {
                    $formatted_html .= '
                        <!-- faxText -->
                        <div class="sideBar_MapAddressElement faxText desktopOnly">
                            <strong>Fax:</strong> ' . $this->safe($v->fax) . '
                        </div><!-- /faxText -->
                    ';
                }

                /* ======================================== */
                /* Formatted Email
                /* ======================================== */

                if (!empty($v->email)) {
                    $formatted_html .= '
                        <!-- emailText -->
                        <div class="sideBar_MapAddressElement emailText desktopOnly">
                            <strong>Email:</strong> <a href="mailto:' . $this->safe($v->email) . '">' . $this->safe($v->email) . '</a>
                        </div><!-- /emailText -->
                    ';
                }

                $formatted_html .= '
                    </div><!-- /sideBar_mapListAddress -->
                ';

            }

            /* ======================================== */
            /* Combined
            /* ======================================== */

            $return .= '
                <!-- sideBar_ElementHolder -->
                <div class="sideBar_ElementHolder sideBar_MapElementHolder">
                    ' . $this->format_title($args, $instance['title']) . '
                    <!-- sideBar_GoogleMapHolder -->
                    <div class="sideBar_GoogleMapHolder">
                        <!-- googleMapWrapper -->
                        <div id="googleMapWrapper" class="desktopOnly">
                            <div id="sideBar_GoogleMap_' . rand(0, 99) . '" class="sideBar_GoogleMap" style="width: 300px; height: 300px;" ' . $instance['attributes'] . '></div>
                        </div><!-- /googleMapWrapper -->
                        <!-- sideBar_MapList -->
                        <div id="sideBar_MapList">
                            ' . $formatted_html . '
                        </div><!-- /sideBar_MapList -->
                    </div><!-- /sideBar_GoogleMapHolder -->
                </div><!-- /sideBar_ElementHolder -->
                <div class="sideBar_Spacer"></div>
            ';

            // Markup WordPress adds after a widget.
            $return .= $args['after_widget'];

            return $return;

        }

        /**
         * Format the city, state, and zip.
         *
         * @return string
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        protected function format_city_state_zip($data)
        {

            // Hold the return value.
            $return = '';

            // CITY
            if (!empty($data->city)) {
                $return .= $data->city;
            }

            // STATE
            if (!empty($data->state)) {
                if (!empty($return)) $return .= ', ';
                $return .= $data->state;
            }

            // ZIP
            if (!empty($data->zip_code)) {
                if (!empty($return)) $return .= ' ';
                $return .= $data->zip_code;
            }

            // COUNTRY
            if (!empty($data->country)) {
                if (!empty($return)) $return .= ', ';
                $return .= $data->country;
            }

            // Trim the return value.
            $return = trim($return);

            return $return;

        }

        /**
         * Format the directions URL.
         *
         * @param array $data
         * @return string
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        protected function format_directions_url($data)
        {

            // Start the URL.
            $return = 'http://maps.google.com/maps?hl=en&amp;f=d&amp;daddr=';

            // Add the address parts.
            $return .= urlencode($data->address_1 . ' ');
            $return .= urlencode($this->format_city_state_zip($data) . ' ');

            // Trim the return value.
            $return = rtrim($return, '+');

            return $return;

        }

        /**
         * Fetch the latitude and longitude for an address using the (free)
         * Google Maps API.
         *
         * @param string $address
         * @return array
         * @author Jimmy K. <jimmy@orbitmedia.com>
         */

        protected function geocode_address($address)
        {

            if (!function_exists('file_get_contents')) {
                // The file_get_contents() function is not enabled.
                return false;
            }

            // Hold the Google API URL.
            $google_api_url = 'http://maps.googleapis.com/maps/api/geocode/xml?address=' . urlencode($address) . '&sensor=false';

            // Ask Google to geocode the address.
            if ($xml_response = @file_get_contents($google_api_url)) {

                // Parse the XML response.
                $xml = new SimpleXMLElement($xml_response);

                if ($xml->status == 'OK') {
                    // Everything is good!
                    return array(
                        'lat' => $xml->result->geometry->location->lat,
                        'lng' => $xml->result->geometry->location->lng,
                    );
                }

                // Response returned an error.
                return false;

            }

            // Couldn't read XML response.
            return false;

        }

    }
