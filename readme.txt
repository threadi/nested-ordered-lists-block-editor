=== Nested Ordered Lists for Block Editor ===
Contributors: threadi
Tags: list, ordered list, numbered list
Requires at least: 6.0
Tested up to: 6.1
Requires PHP: 7.4
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Stable tag: 1.0.0

== Description ==

The creation of numbered ordered lists such as 1.1, 1.2, 1.3, 2.1 etc. in Block Editor is now possible! This plugin adds this missing function at the list block. Use individual numbers up to the 4th level. Also reversed lists (2.2, 2.1, 1.3, 1.2, 1.1 etc.) and additional list-styles (like upper- and lowercase roman and alphabet) are supported.

== Usage ==

1. Open a page where you want to use nested ordered lists.
2. Edit this page with block editor.
3. Add a normal list-block.
4. Choose ordered list to be able to use its list-style.
5. Check "Use nested ordered lists" on the right to enable them.

The development repository is on [GitHub](https://github.com/threadi/nested-ordered-lists-block-editor).

== Screenshots ==

== Installation ==

1. Upload "nested-ordered-lists-block-editor" to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.

== Frequently Asked Questions ==

= Can I use this also in Divi, Elementor, other PageBuilder or the Classic Editor? =

No, the plugin is intended solely for Block Editor aka Gutenberg and always will be.

= Can I use other blocks between the list items, e.g. for a description text? =

Yes, as follows: enter the desired content between the individual list blocks. The list blocks will now all begin with "1". For the 2nd list block, enter the number 2 in the "Initial value" field. This will update the view in the block accordingly. Now enter "3" in the next list block, etc.

= Can I use different list-styles in one list? =

No, not yet. As soon as it is possible in Block Editor, this will be added.

== Changelog ==

= 1.0.0 =
* Initial release