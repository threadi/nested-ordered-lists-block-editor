# Changelog

## [2.0.1] - 02.03.2025

### Added

- Added link to support forum on our plugin in plugin list

### Fixed

- Fixed some typos

## [2.0.0] - 03.01.2025

### Added

- Added 3 new iconsets for the lists
- Added value for indention of lists
- Added GitHub action to build release ZIP
- Added Plugin Check for each release (additional to complete WordPress Coding Standard check)
- Added minification of generated styles to optimize loading times
- Added new hooks
- Added help page for first steps
- Added hint for supportforum
- Added check if Block Editor is disabled and show warning about it

### Changed

- New minimum requirement to WordPress 6.6 and PHP 8.1
- Moved changelog to GitHub
- Renamed CSS-handle
- Optimized version detection for own files
- Optimized loading of style of this plugin: only if a list block is used
- Updated dependencies

### Removed

- Removed language files from release

### Fixed

- Inherited settings not working
- Fixed content of blueprint for Playground-preview

## [1.1.3] - 05.07.2024

### Changed

- Do not load admin-only styles and scripts in frontend
- Compatibility set for WordPress 6.6
- Updated dependencies

### Fixed

- Fixed styling for sub-lists


## [1.1.2] - 09.03.2024

### Added

- Added check for WCS on build of each release

### Changed

- Compatibility set for WordPress 6.5.3
- Compatibility with WordPress Coding Standards 3.1
- Updated dependencies

## [1.1.1] - 08.03.2024

### Changed

- Compatibility set for WordPress 6.5
- Updated dependencies

### Fixed

- Fixed loading of JSON translations for block editor

## [1.1.0] - 25.11.2023

### Added

- Added option to inherit settings to sublists (default enabled)

### Changed

- Optimized handling for sublists since WordPress 6.3
- Enabling a custom list style enabled the nested lists now automatically
- Changed text-domain to match WordPress repository requirements
- Updated dependencies

## Removed

- Remove language files from package, translations are completely run via WordPress translations

## [1.0.3] - 03.10.2023

### Changed

- Compatibility set for WordPress 6.4
- Compatibility with WordPress Coding Standards 3.0

## [1.0.2] - 15.07.2023

### Changed

- Optimized handling to enable the ordered styles
- Compatibility set for WordPress 6.3
- Compatible with WordPress Coding Standards
- Updated dependencies

### Fixed

- Fixed loading of scripts in Block Editor

## [1.0.1] - 19.03.2023

### Added

- Added italian as language

### Changed

- Compatibility set for WordPress 6.2
- Updated dependencies

### Fixed

- Fix for: Nested list style should override parent's (thanks @vHeemstra)

## [1.0.0] - 22.11.2022

### Added

- Initial release
