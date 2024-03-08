# Nested ordered lists

This repository is the database for the plugin _Nested ordered lists_. This provides a Gutenberg block-addition to use the list-block with nested ordered lists and some list-styles.

## Usage

After checkout go through the following steps:

1. copy _build/build.properties.dist_ to _build/build.properties_.
2. modify the build/build.properties file - note the comments in the file.
3. execute the command in _build/_: `ant init`
4. execute the command in the plugin-directory `npm start`
5. after that the plugin can be activated in WordPress

## Release

1. increase the version number in _build/build.properties_.
2. execute the following command in _build/_: `ant build`
3. after that you will finde in the _release/_ directory a zip file which could be used in WordPress to install it.

## Translations

I recommend to use [PoEdit](https://poedit.net/) to translate texts for this plugin.

### generate pot-file

Run in main directory:

`wp i18n make-pot . languages/nested-ordered-lists-for-block-editor.pot --exclude=src,svn`

### update translation-file

1. Open .po-file of the language in PoEdit.
2. Go to "Translate > "Update from POT-file".
3. After this the new entries are added to the language-file.

### export translation-file

1. Open .po-file of the language in PoEdit.
2. Go to File > Save.
3. Upload the generated .mo-file and the .po-file to the plugin-folder languages/

### generate json-translation-files

Run in main directory:

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

* reversed orders numbered list with start numbers > 0 on level 2 will not work in frontend.

## Check for WordPress Coding Standards

### Initialize

`composer install`

### Run

`vendor/bin/phpcs --extensions=php --ignore=*/attributes/*,*/example/*,*/css/*,*/vendor/*,*/node_modules/*,*/svn/* --standard=WordPress .`

### Repair

`vendor/bin/phpcbf --extensions=php --ignore=*/attributes/*,*/example/*,*/css/*,*/vendor/*,*/node_modules/*,*/svn/* --standard=WordPress file`
