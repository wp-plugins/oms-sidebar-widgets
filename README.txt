=== OMS Sidebar Widgets ===
Contributors: jklatt86, sorensenss
Tags: sidebar, image, prettyphoto, video, youtube, vimeo, map, location, google, widget
Requires at least: 3.0.1
Tested up to: 3.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WordPress plugin to display image, video, and/or map widgets in the sidebar.

== Description ==

A collection of widgets for displaying images, videos, and/or maps in your
website sidebars. Images and videos play in a lightbox and maps are powered by
the Google Maps API. Map locations can be automatically geocoded or specific
coordinates can be specified.

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
