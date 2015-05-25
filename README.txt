=== OMS Sidebar Widgets ===
Contributors: jklatt86, sorensenss
Tags: sidebar, image, prettyphoto, video, youtube, vimeo, map, location, google, widget
Requires at least: 3.0.1
Tested up to: 4.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WordPress plugin to display image, video, and/or map widgets in the sidebar.

== Description ==

A collection of widgets for displaying maps, images, and/or videos in your
website sidebars.

= Sidebar Map =
Maps are powered by the Google Maps API v3. Locations can be automatically
geocoded or latitude and longitude coordinates can be specified for more precise
control. Multiple map locations (pins) are supported.

= Sidebar Image & Sidebar Video =
Images and videos play in a `prettyPhoto` lightbox. External images are
supported. Videos can be hosted on either YouTube or Vimeo. Viddler is currently
not supported.

= Notes =
This plugin pairs well with the `Simple Page Sidebars` plugin to allow different
images, videos, or maps to be displayed on individual pages.

== Installation ==

1. Upload the `oms-sidebar-widgets` plugin directory to the `/wp-content/plugins/`
directory on your server.
2. Activate the plugin through the `Plugins` menu in WordPress.
3. Navigate to the `Widgets` page in WordPress.
4. Drag and drop images, videos, or map widgets to your sidebar.
5. Configure each widget.
6. Profit!

== Frequently Asked Questions ==

= Which lightbox do images and videos open in? =

This plugin uses `prettyPhoto` to display images and videos in a lightbox.

= Which service is used for displaying maps? =

This plugin uses the `Google Maps API v3` to display maps and geocode addresses.

= Can I change the marker image for maps? =

Yes you can! You can specify the icon image to use for each map. Alternatively,
if one is not supplied, the default one will be used.

== Screenshots ==

1. An example of a sidebar map. Left, widget output; right, widget form.
2. An example of a sidebar video. Left, widget output; right, widget form. (Sidebar Image is very similar.)
3. An example of a sidebar image lightbox. (Sidebar Video is very similar.)

== Changelog ==

= 0.1 =
The initial release of this plugin.

= 1.0 =
The finalized release of this plugin.

= 1.1 =
Minor bug fixes and refactoring.

= 2.1 =
The refactored release of this plugin. Added multiple pins to map widgets.

= 2.2 =
Changed array object creation from [] to array() for < PHP 5.4.

= 2.3 =
Added checks to make sure the prettyPhoto library is loaded before initializing.

= 2.4 =
Fixed multiple map widgets bug where fields were being duplicated.

= 2.5 =
Fixed prettyPhoto XSS vulnerability by updating prettyPhoto to 3.1.6.
