=== Nested Ordered Lists for Block Editor ===
Contributors: threadi
Tags: list, ordered list, numbered list
Requires at least: 6.6
Tested up to: 6.7
Requires PHP: 7.4
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Stable tag: @@VersionNumber@@

Extends the list block in Block Editor with options for numbered ordered lists such as 1.1, 1.2, 1.3, 2.1 etc.!

== Description ==

Extends the list block in Block Editor with options for numbered ordered lists such as 1.1, 1.2, 1.3, 2.1 etc.! Use individual numbers up to the 4th level. Also reversed lists (2.2, 2.1, 1.3, 1.2, 1.1 etc.) and additional list-styles (like upper- and lowercase roman and alphabet) are supported.

The development repository is on [GitHub](https://github.com/threadi/nested-ordered-lists-block-editor/).

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

= @@VersionNumber@@ =
* Added GitHub action to build release ZIP
* New minimum requirement for WordPress 6.6
* Moved changelog to GitHub
* Updated dependencies
* Fixed: inherited settings not working

[older changes](https://github.com/threadi/nested-ordered-lists-block-editor/changelog.md)
