=== WP Sticky Sidebar ===
Contributors: damiroquai
Donate link: http://wordpress.transformnews.com/contact
Tags: sticky sidebar, fixed sidebar, floating sidebar, sidebar, sticky
Requires at least: 3.5.1
Tested up to: 4.9.4
Stable tag: 1.2.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin glues website's sidebar, making it permanently visible while scrolling.

== Description ==
Plugin glues website's sidebar, making it permanently visible while scrolling. Since sidebar is always visible it increases website's usability, accessibility and therefore gets better click through rate.

By default, it uses "#secondary" css id under "Sticky Class" setting field and that should be modified for different themes to make them work. Don’t forget this, it’s a mandatory field for certain themes. Use additional margin top to fine tune sidebar position.

Sticky sidebar plugin will work out of box with some themes which use "#secondary" id for sidebar by default such as: Twenty Sixteen, Twenty Fourteen, Twenty Twelve, Total, Flat Bootstrap and many more… Plugin is localized (multi language support) and responsive (as far as your theme is).

[Plugin Home + Demo URL][1] 

Plugin Options:

- Sticky Class: CSS class or id of the sidebar element desired to be sticky. Defaults to “#secondary”. This is mandatory field and it must be filled! 

- Container Class: Container element class or id. If left blank script will try to guess. It must be element that contains both sidebar and content. Usually it is #main, #main-content or #primary. Mostly this parameter is not needed for majority of themes.

- Additional Top Margin: An additional top margin in pixels. Defaults to 0. …

- Additional Bottom Margin: An additional bottom margin in pixels. Defaults to 0. 

- Disable if screen width is smaller than: desired number of pixels. It disables script on mobiles or any device which screen is not wide as entered number of pixels. 

- Update sidebar height: Troubleshooting option, try this if your sidebar loses its background color. True or False.

- Disable at: front page, blog page, pages, posts, categories, tags, archives 

- Enable for specific posts and pages if previously disabled site wide.


Plugin integrates magnificent [Theia Sticky Sidebar][2] v1.7.0 javascript code (Released under the MIT license, Copyright 2013-2016 WeCodePixels and other contributors) with WordPress… 

[1]: http://wordpress.transformnews.com/plugins/mystickysidebar-sticky-sidebar-for-wordpress-1083
[2]: https://github.com/WeCodePixels/theia-sticky-sidebar

== Installation ==
Install like any other plugin. After install activate. 
Go to Settings / WP Sticky Sidebar and change Sticky Class to .your_sidebar_class or sidebar css id.
Use additional margin top to fine tune sidebar position.


== Frequently Asked Questions ==

= How to find Sticky Class, what should I enter here? =
So this depends which theme do you use, examine the code (Firefox: right click on sidebar and ”Inspect Element”; Chrome: right click on sidebar than select “Inspect”) and find element in which sidebar is situated. This element have some class or id, and that’s the Sticky Class we need. If using class than don’t forget to ad dot (.) in front of class name, or hash (#) in front of id name.
= After update my plugin stopped working? =
Try to clear website cache, or even your browser cache. In some cases, try to save plugin settings before clearing cache.

== Screenshots ==

1.  screenshot-1.png WP Sticky Sidebar backend settings.


== Changelog ==
= 1.2.5 =
* Fixed: enable / disable at search pages
= 1.2.4 =
* Fixed: additional margin top when admin bar is showing
= 1.2.3 =
* Improved: Better compatibility with various themes
= 1.2.2 =
* Added options: Disable at: front page, blog page, pages, posts, categories, tags, archive
* Added options: Enable for: Enable only selected pages or posts
= 1.2.1 =
* Added options: Disable if screen size is smaller than number of pixels
= 1.2 =
* Updated script: Theia sticky menu v1.7.0
* Added options: additional margin bottom + update sidebar height
= 1.1 =
* Fixed: Notice: Undefined index: myfixedside_disable_small_screen
= 1.0 =
* First release of myStickysidebar plugin

== Upgrade Notice ==
= 1.2.3 =
* Improved: Better compatibility with various themes
= 1.2.2 =
* Added options: Disable at: front page, blog page, pages, posts, categories, tags, archive
* Added options: Enable for: Enable only selected pages or posts
= 1.2.1 =
* Added options: Disable if screen size is smaller than number of pixels
= 1.2 =
* Updated script: Theia sticky menu v1.7.0
* Added options: additional margin bottom + update sidebar height
= 1.1 =
* Fixed: Notice: Undefined index: myfixedside_disable_small_screen
= 1.0 =
* First release of myStickysidebar plugin
