=== Doc It (Documentation)===
Contributors: slickremix
Tags: documentation, docs, premium content, logged in, logged out, doc, post, page, organize, notes, colored menu, menu, color options, knowledge, knowledge base, order, plugins, plugin, wordpress, wordpress plugin, word, simple, easy, text, text document, documents, faq, faqs, quoble, breadcrumbs, footer navigation
Requires at least: 3.5
Tested up to: 4.4.2
Requires at Doc It Plugin least: 1.1.6
Stable tag: 1.1.7
License: GPLv2 or later

Create great looking documentation for anything with this plugin. Great for FAQS and more!

== Description ==

With this plugin you can organize your documentation for whatever it is you need to tell people about. For instance if you sell plugins and need to explain how it all works with FAQS, or you have a book and want to create an index of chapters, or a video game's information, the list goes on and on. View an Example and documentation of this plugin all in one place. [http://slickremix.com/doc-it/](http://slickremix.com/doc-it/)

Here's a look at how fast you can be [setup](http://www.youtube.com/watch?v=h6JLEDmsNWk)! 
[youtube http://www.youtube.com/watch?v=h6JLEDmsNWk]

[See Demo](http://www.slickremix.com/doc-it/)

= Free Plugin Features =
  * Create Slick Documentation for anything.
  * Create a topic/item to document with a sidebar menu.
  * Attach an "Introduction" page to each Doc It topic/item.
  * Automatically generated breadcrumbs for simple navigation.
  * Automatically generated Next/Previous links (on Doc It posts) for simple navigation.
  * Slide down sidebar menu options for sub menu items.
  * Easy Drag-and-Drop organize Doc It Posts and Categories.
  
= Premium Extension Features =
  * Unlimited Doc It topics/items.
  * Unlimited Doc It sidebar menus.
  * Settings page options to change colors easily for sidebar menu.
  * Create video pop-up for Vimeo and Youtube videos using [di-video][/di-video] shortcode.
  
Get the [Premium Version](http://www.slickremix.com/downloads/doc-it-premium-extension/) which allows you to add unlimited menus and change the colors of the menu.
  
= SUPPORT FORUM =
  * Having problems, or possibly looking to extend our plugin to fit your needs? You can find answers to your questions or drop us a line at our [Support Forum](http://www.slickremix.com/support-forum/).

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

== Change-log ==
= Version 1.1.7 Wednesday March 30th, 2016 =
 * FIXED: Other posts or custom posts were falling out of date order with our plugin. Footer navigation for other posts were not following the proper order either.
 * NEW: Option to remove the Breadcrumbs on our plugin.
 * NEW: Option to remove the Footer Navigation on our plugin.
 * NEW: If you choose the option to close the sub menu on the settings page when you click on them in the front end the sub menu posts will also show.
 * PREMIUM: Video Popup re-styled and responsive. [di-video][/di-video]
 * PREMIUM: Now you can choose to show premium content. Limit the amount of words on all posts while being logged out or control the amount of words to show per post while being logged out. Customise the word count on the list of posts too. You can even customise the text for the You must be logged in box that will appear under the limited content while being logged out. You can also choose to show a small menu above the documents sidebar to take your users to the Home Docit Page and Login or Logout while being directed back the current page visited. All these options will appear on the Settings page under the Premium Content box. Lastly, if you wanted to show specific videos while being logged out you can use the shortcode [di-video-logged-out][/di-video-logged-out] for example. Place your youtube or vimeo iframe in between the shortcode and you will get a nice video popup.  
 * COMING SOON: Recode how the sort order options work. Currently we are aware of a bug where sorting the categories on the backend will cause the footer navigation to sometimes not follow the next or previous posts correctly.
	
= Version 1.1.6 Sunday January 10th, 2016 =
 * FIXED: Now you can delete the main menu item on the settings page in the free version in case you want to change the name.
 * FIXED: Limit now set on the Menu Name creation input. Wordpress only allows a maximum of 32 characters for Custom Taxonomy Names.
 * FIXED: Woo settings page Error.

 = Version 1.1.5 Wednesday December 16th, 2015 =
 * FIXED: Fontawesome conflict with some themes.
 * FIXED: Issues with sort order confilcits in wp-admin. One last bug we have to address is grabbing the sub categories along with the main category when trying to resort categories in wp-admin, anyone who wants to help feel free to fork the [github](https://github.com/wp-plugins/slick-doc-it) and checkit out.
 * REMOVED: Mutliple php Notices and warnings when debug set to true.
 * TRUNCATED: Minifed the CSS and removed a call to fontawesome css file.
 * NOTICE: Premium Users will need to update.
 
= Version 1.1.4 Monday November 9th, 2015 =
 * FIXED: Added array( 'jquery' ) onto the docit.js enque to allow our file to come after jquery. Thanks to [@tkaratug](https://wordpress.org/support/topic/accordion-does-not-working) for bringing this to our attention.
	
 = Version 1.1.3 Wednesday July 29th, 2015 =
 * CLEANED UP: The Plugin has been Re-built using NameSpacing and Classification
 
 = Version 1.1.2 Monday June 16th, 2014 =
 * FIXED: Category Sorting.
 
 = Version 1.1.1 Thurdsay June 12th, 2014 =
 * FIXED: Taxonomy template issue.

 = Version 1.1.0 Thurdsay June 5th, 2014 =
 * FIXED: License Manager. If you don't have a premium version for this plugin then you don't need to worry about updating to this version.
 
 = Version 1.0.9 Friday May 9th, 2014 =
 * Fixed: CSS issue that was overiding styles for Jetpack sharing. View working demo here, http://wordpress.org/support/view/plugin-reviews/slick-doc-it
 
  = Version 1.0.8 Sunday March 4th, 2014 =
 * Fixed: Sorting order works again for all post lists and categories in the admin panel.
 * Thanks to noodles91 for pointing out the problem above.
 * WP Bug: Category sorting will remove all dashes next to sub categories, and when you refresh the page they do not come back. Bug reported to wordpress.
 
 = Version 1.0.7 Monday April 28th, 2014 =
 * Fixed: Previous and Next error when only one post present.
 * Fixed: All posts with excerpts show when clicking on a category now.
 * Fixed: Previous and Next buttons now go to the next post proper when only one sub categpry is present.
 * Fixed Admin: Sorting feature scripts for posts and categories is now only enqueued for Doc It.
 * NOTICE: Premium version users should upgrade as well. We added a missing js file for the video popup.
 * Big thanks to all those who have helped in pointing out these errors. You know who you are!
 
 = Version 1.0.6 Thursday Febuary 6th, 2014 =
 * Fixed: Easy navigation links on bottom of the posts.
 * Fixed: Breadcrumb Issue with it not showing properly.
 * Fixed: UI fixes for settings page and front end.
 * Fixed: js fixes for front end.
 * NOTICE: Premium version 1.0.3 now requires a site license.

 = Version 1.0.5 Monday January 27th, 2014 =
 * Fixed: New Settings Page UI for wp 3.8 update.
 * Fixed: Added ellipsis to post titles that show when clicking any of the main categories.
 
 = Version 1.0.4 Tuesday, January 2nd, 2014 =
 * Fixed: Menu Icon to work with new wp 3.8 dashboard.
 * Added: Doc It sidebar sub menu items now have option (in settings page) to be automatically closed.
 * Added: Automatically generated easy next/previous posts navigation to all documentation.
 * Added: Premium Version has shortcode option to create pop-up for Vimeo and Youtube videos! 

 = Version 1.0.3 Tuesday, November 19th, 2013 =
 * Fixed: Install php call out of order. Fixes documents not saving order.
 
 = Version 1.0.2 Tuesday, November 19th, 2013 =
 * Fixed: Buggy Database Table Name!

 = Version 1.0.1 Tuesday, November 19th, 2013 =
 * Added: Ability to reorder documents for the Doc It sidebar.
 * Added: Ability to reorder Document Item categories for the Doc It sidebar.
 * Added: New settings options, including custom CSS area.
 * Big Thanks to everyone in [Advanced WordPress](https://www.facebook.com/groups/advancedwp/) Facebook Group for the feedback and testing!
 
 = Version 1.0.0 =
 * Initial Release

== Frequently Asked Questions ==

= Are there Extensions for this plugin? =

Yes. Currently we have 1 and are working on more! http://www.slickremix.com/downloads/doc-it-premium-extension/
 
= This plugin seems like it may be complex. Are there tutorials for the plugin? = 

Yes. Video coming soon. And detailed documentation which will be utalized by this plugin.

If you have more questions or would like to view other users questions please visit our support forum at http://www.slickremix.com/support-forum/

== Screenshots ==

See Working Example and Docs all in one here. http://www.slickremix.com/doc-it/