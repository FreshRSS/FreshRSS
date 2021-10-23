# Contributing to internationalization (i18n)

Thanks to our contributors, FreshRSS is translated into more than 15 languages. This section will explain the basics of internationalization in FreshRSS, from translating the application to your own language to making a specific change.

## Overview

It is common (and that's an understatement) to want to show some text to the user. The problem is that FreshRSS has users of different nationalities. It is therefore necessary to be able to manage different languages in order not to remain confined to English or French.

The solution is to use the `Minz_Translate` module, which allows dynamic translation of FreshRSS. Before using this module, it is necessary to know where to find the strings to be translated. Each language has its own subdirectory in a parent directory named `app/i18n/`. For example, English language files are located in [`app/i18n/en/`](/app/i18n/en/). There are seven different files:

* `admin.php` for anything related to FreshRSS administration
* `conf.php` for configuration
* `feedback.php` contains translations of feedback messages
* `gen.php` stores what is global to FreshRSS (`gen` stands for “general”)
* `index.php` for the main page that lists feeds and the About page
* `install.php` contains strings related to the installation
* `sub.php` for subscription management (`sub` stands for “subscription”)
* `user.php` contains some strings related to the User model

This organization makes it possible to avoid a single huge translation file.

The translation files are quite simple: it's only a matter of returning a PHP array containing the translations. As an example, here's an extract from [`app/i18n/fr/gen.php`](/app/i18n/fr/gen.php):

```php
<?php

return array(
	'action' => [
		'actualize' => 'Actualiser',
		'back_to_rss_feeds' => '← Retour à vos flux RSS',
		'cancel' => 'Annuler',
		'create' => 'Créer',
		'disable' => 'Désactiver',
	),
	'freshrss' => array(
		'_' => 'FreshRSS',
		'about' => 'À propos de FreshRSS',
	),
	// ...
];
```

Each value can be referenced by a key: it consists of a series of identifiers separated by dots. The first identifier indicates from which file to extract the translation, while the following ones indicate array entries. Thus, the `gen.freshrss.about` key is referencing the `about` entry from the `freshrss` entry which is part of the main array returned by the `gen.php` file. This allows us to further organize our translation files.

You should not have to write the array by yourself and we provide several commands to ease the manipulation of these files. Let's see some common use cases.

## Add support for a new language

If you want to add support for a language which isn't supported by FreshRSS yet, you can run this command:

```sh
make i18n-add-language lang=[your language code]
```

You must replace `[your language code]` by the language tag of your language. It must follow the [IETF BCP 47 standard](https://en.wikipedia.org/wiki/IETF_language_tag). For instance, English is `en` and French is `fr`. You can target a specific region with a subtag, for instance `pt-br` for Brazilian Portuguese. If you're not sure of the code, Wikipedia might be a good start to find it or you can ask us for help too.

The command will create a new subfolder under `app/i18n/` and copy the strings from the reference language (i.e. English). It will also mark all the translations with a special tag represented by a comment: `// TODO - Translation`. We'll see in the next section how to translate the strings.

## Translate the interface

You might have noticed some strings are not yet translated from English even though you've selected a different language. This is because we mostly speak English or French and it's pretty difficult to us to speak all the different languages!

To update a string, you just have to open its file, find the string, and change it (without removing the quotes around it!) You might want to remove the comment at the end of the line, but you should prefer to use the following command:

```sh
make i18n-format
```

It will remove the comments on the lines that you've changed, and will reformat the file correctly. If you've made any mistakes, it will fix them automatically or it will tell you it can't (well… the command will dramatically fail without any damage, don't worry).

The strings to translate can be easily found in the translations files thanks to the tag we spoke about at the end of the previous section. Indeed, it indicates to our tools that the strings are not translated yet. This means you can find them with Git. For instance for the Greek language:

```sh
git grep TODO app/i18n/he
```

## Acknowledge a false-positive

Our tool detects if a string needs to be translated if it equals to the English version. For instance, the word “version” is the same in English and French. Thus, our tool would mark the French word to be translated. This is, in fact, the case for the `index.about.version` key. This case is considered as a false-positive because the word _is_ actually translated. To aknowledge such translations, you can run:

```sh
make i18n-ignore-key lang=fr key=index.about.version
```

This command adds an entry in the [`cli/i18n/ignore/fr.php` file](/cli/i18n/ignore/fr.php) so the key can be considered as translated.

## Add/remove/update a key

If you're developping a new part of the application, you might want to declare a new translation key. Your first impulse would be to add the key to each file manually: don't do that, it's very painful. We provide another command:

```sh
make i18n-add-key key=the.key.to.add value='Your string in English'
```

This adds the key to all the files. It’ll be in English, waiting for other translators.

Conversely, you may want to remove a key that is no longer used in the application with:

```sh
make i18n-remove-key key=the.key.to.remove
```

Finally, if the English version of a string needs to be changed, you need to consider two cases. If the change doesn't impact the meaning of the sentence, and therefore other languages don't need to change (e.g. to fix a typo), you should make the change manually in the file. In any other case, you should use the following command:

```sh
make i18n-update-key key=the.key.to.change value='The new string in English'
```

The key will simply be removed and added back with the new value.

## How to access a translation programmatically

To access these translations, you must use the `_t()` function (which is a shortcut for `Minz_Translate::t()`). Code example:

```html
<p>
	<?= _t('gen.freshrss.about') ?>
</p>
```

The function expects a translation key, but there's a special case that sometimes makes life easier: the `_` identifier. This must necessarily be present at the end of the chain and gives a value to the higher-level identifier. It's pretty hard to explain but very simple to understand. In the example given above, an `_` is associated with the value `FreshRSS`: this means that there is no need to write `_t('gen.freshrss._')` but `_t('gen.freshrss')` suffices.

`_t()` can take any number of variables. The variables will then be replaced in the translation if it contains some “conversion specifications” (usually `%s` or `%d`). You can learn more about these specifications in the [`sprintf()` PHP function documentation](https://www.php.net/manual/function.sprintf).

For instance, the English translation for `gen.auth.keep_logged_in` is `Keep me logged in <small>(%s days)</small>`. It means this translation expects a string to be passed as an argument to the `t()` function (well, it should be a `%d` because we want a number here, but it doesn't matter). For instance:

```php
<label>
	<input type="checkbox" name="keep_logged_in" />
	<?= _t('gen.auth.keep_logged_in', 30) ?>
</label>
```
