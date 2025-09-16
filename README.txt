=== CS Books Loader ===
Contributors: hlakkad1998
Tags: books, custom post type, ajax, filters, shortcode, pagination
Requires at least: 5.8
Tested up to: 6.6
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

An advanced book listing plugin with custom filters (author, price, publish date) and AJAX-based pagination. Includes cache management for optimized performance.

== Description ==

**Advanced Book Listing with Custom Filters & AJAX Pagination** allows you to display books from a custom post type with dynamic filters and seamless AJAX pagination.

= Features =
* Custom Post Type: **Books** (`wp-admin/edit.php?post_type=books`)
* Frontend shortcode: `[advanced_books]`
* Filters:
  * Filter by author (first letter)
  * Filter by price range
  * Filter by publish date (newest/oldest)
* AJAX-powered pagination ("Load More" button)
* Cache management screen: `wp-admin/edit.php?post_type=books&page=cs-books-cache`
* Fully translatable and WordPress coding standards compliant

== Installation ==

1. Upload the plugin folder.zip to `/wp-content/plugins/` from https://github.com/h-lakkad1998/cs-book-loader
2. Activate the plugin from **Plugins > Installed Plugins**
3. Navigate to **Books > Add New** to create books
4. Use the shortcode `[advanced_books]` inside a page or post

== Frequently Asked Questions ==

= How do I display the book list? =
Use the shortcode: `[advanced_books]`

= Where do I manage book content? =
Go to: `wp-admin/edit.php?post_type=books`

= How do I clear the cache? =
Visit: `wp-admin/edit.php?post_type=books&page=cs-books-cache`

== Changelog ==

= 1.0.0 =
* Initial release with:
  * Custom post type "Books"
  * `[advanced_books]` shortcode
  * AJAX filtering + pagination
  * Cache management page

== Upgrade Notice ==

= 1.0.0 =
First release. Adds shortcode, custom post type, filters, and AJAX pagination.