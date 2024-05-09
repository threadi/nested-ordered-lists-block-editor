=== Nested Ordered Lists for Block Editor ===
Contributors: threadi
Tags: list, ordered list, numbered list
Requires at least: 6.0
Tested up to: 6.5.3
Requires PHP: 7.4
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Stable tag: 1.1.2

Extends the list block in Block Editor with options for numbered ordered lists such as 1.1, 1.2, 1.3, 2.1 etc.!

== Description ==

Extends the list block in Block Editor with options for numbered ordered lists such as 1.1, 1.2, 1.3, 2.1 etc.! Use individual numbers up to the 4th level. Also reversed lists (2.2, 2.1, 1.3, 1.2, 1.1 etc.) and additional list-styles (like upper- and lowercase roman and alphabet) are supported.

== Usage ==

1. Open a page where you want to use nested ordered lists.
2. Add a normal list block.
3. Choose ordered list to be able to use its list-style.
4. Check "Use nested ordered lists" on the right to enable them.

== Screenshots ==

== Installation ==

1. Upload "nested-ordered-lists-for-block-editor" to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. No configuration required. Use it straight away.

== Frequently Asked Questions ==

= Can I use this also in Divi, Elementor, other PageBuilder or the Classic Editor? =

No, the plugin is intended solely for Block Editor aka Gutenberg and always will be.

= Can I use other blocks between the list items, e.g. for a description text? =

Yes, as follows: enter the desired content between the individual list blocks. The list blocks will now all begin with "1". For the 2nd list block, enter the number 2 in the "Initial value" field. This will update the view in the block accordingly. Now enter "3" in the next list block, etc.

= Can I use different list-styles in one list? =

Yes, since WordPress 6.3 you could create list where this plugin supports to set different list-styles for each list.

== Changelog ==

= 1.0.0 =
* Initial release

= 1.0.1 =
* Added italian as language
* Compatibility set for WordPress 6.2
* Updated dependencies
* Fix for: Nested list style should override parent's (thanks @vHeemstra)

= 1.0.2 =
* Optimized handling to enable the ordered styles
* Compatibility set for WordPress 6.3
* Compatible with WordPress Coding Standards
* Updated dependencies
* Fixed loading of scripts in Block Editor

= 1.0.3 =
* Compatibility set for WordPress 6.4
* Compatibility with WordPress Coding Standards 3.0

= 1.1.0 =
* Added option to inherit settings to sublists (default enabled)
* Optimized handling for sublists since WordPress 6.3
* Enabling a custom list style enabled the nested lists now automatically
* Changed text-domain to match WordPress repository requirements
* Remove language files from package, translations are completely run via WordPress translations
* Updated dependencies

= 1.1.1 =
* Compatibility set for WordPress 6.5
* Updated dependencies
* Fixed loading of JSON translations for block editor

= 1.1.2 =
* Added check for WCS on build of each release
* Compatibility set for WordPress 6.5.3
* Compatibility with WordPress Coding Standards 3.1
* Updated dependencies
