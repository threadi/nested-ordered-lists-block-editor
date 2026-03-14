# Nested Ordered Lists for Block Editor

## About

This repository provides the features of the WordPress plugin _Nested Ordered Lists for Block Editor_. The repository is used as a basis for deploying the plugin to the WordPress repository. It is not intended to run as a plugin as it is, even if that is possible for development.

## Usage

After checkout go through the following steps:

### By hand

Run the following commands in this order:

1. `composer install`
2. `npm i`
3. `npm run build`
4. after that the plugin can be activated in WordPress.

### Using ant

1. copy _build/build.properties.dist_ to _build/build.properties_.
2. modify the build/build.properties file - note the comments in the file.
3. execute the command in _build/_: `ant init`
4. after that the plugin can be activated in WordPress

## Release

### From local environment by hand

1. `composer install`
2. `npm i`
3. `npm run build`
4. `vendor/bin/phpstan analyse`
5. `vendor/bin/phpcbf --standard=ruleset.xml .`
6. `vendor/bin/phpcs --standard=ruleset.xml .`
7. Set version nummer in _readme.txt_ and _external-files-in-media-library.php_.
8. Create the release ZIP with all necessary folders and files.

### From local environment with ant

1. increase the version number in _build/build.properties_.
2. execute the following command in _build/_: `ant build`
3. after that you will finde in the _release/_ directory a zip file, which could be used in WordPress to install it.

### On GitHub

1. Create a new tag with the new version number.
2. The release zip will be created by a GitHub action.

## Translations

I recommend translating this plugin in the [WordPress Translating tool](https://translate.wordpress.org/projects/wp-plugins/nested-ordered-lists-for-block-editor/).

For manual translation I recommend to use [PoEdit](https://poedit.net/) to translate texts for this plugin.

### generate pot-file

Run in the main directory:

`wp i18n make-pot . languages/nested-ordered-lists-for-block-editor.pot --exclude=src/,svn/`

### update translation-file

1. Open .po-file of the language in PoEdit.
2. Go to "Translate" > "Update from POT-file".
3. After this the new entries are added to the language-file.

### export translation-file

1. Open .po-file of the language in PoEdit.
2. Go to File > Save.
3. Upload the generated .mo-file and the .po-file to the plugin-folder languages/

### generate json-translation-files

Run in the main directory:

`wp i18n make-json languages`

OR use ant in build/-directory: `ant json-translations`

## Build blocks

### Requirements

`npm install`

### Run for development

`npm start`

### Run for release

`npm run build`

Hint: will be called by ant-command mentioned above.

## Build styles

Run `ant generate-css` in _build/_.

## Known bugs

* reversed orders numbered list with start numbers > 0 on level 2 will not work in the frontend.

## Check for WordPress Coding Standards

### Initialize

`composer install`

### Run

`vendor/bin/phpcs --ignore= --standard=ruleset.xml .`

### Repair

`vendor/bin/phpcbf --standard=ruleset.xml .`

## Generate documentation

`vendor/bin/wp-documentor parse . --exclude=vendor --exclude=node_modules --exclude=svn --format=markdown --output=docs/hooks.md --prefix=nolg_`

## Check for WordPress VIP Coding Standards

Hint: this check runs against the VIP-GO-platform, that is not our target for this plugin. Many warnings can be ignored.

### Run

`vendor/bin/phpcs --extensions=php --ignore=*/attributes/*,*/example/*,*/css/*,*/vendor/*,*/node_modules/*,*/svn/* --standard=WordPress-VIP-Go .`
