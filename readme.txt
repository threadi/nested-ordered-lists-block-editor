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

Yes, you could set different list-styles for each list.

= Can I use other icons as list points? =

Yes, since version 2.0.0 you can use Bootstrap-, Dash- or FontAwesome-icons on each list.

== Changelog ==

= @@VersionNumber@@ =
- Added 3 new iconsets for the lists
- Added GitHub action to build release ZIP
- Added Plugin Check for each release (additional to complete WordPress Coding Standard check)
- Added minification of generated styles to optimize loading times
- Added new hooks
- Added help page for first steps
- Added check if Block Editor is disabled and show warning about it
- New minimum requirement to WordPress 6.6 and PHP 8.1
- Moved changelog to GitHub
- Renamed CSS-handle
- Optimized version detection for own files
- Optimized loading of style of this plugin: only if a list block is used
- Updated dependencies
- Removed language files from release
- Inherited settings has been not working
- Fixed content of blueprint for Playground-preview

[older changes](https://github.com/threadi/nested-ordered-lists-block-editor/changelog.md)
