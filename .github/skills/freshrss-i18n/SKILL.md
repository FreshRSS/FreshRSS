---
name: freshrss-i18n
description: Add, move, or format translation strings in FreshRSS. Use when modifying UI text that needs translation (i18n). Handles all supported languages automatically.
allowed-tools: Bash(php:*) Bash(composer:*) Bash(make:*) Read Grep
---

# FreshRSS translation management (i18n)

For instructions and commands to work with translations, make sure to obey [i18n.instructions.md](../../instructions/i18n.instructions.md).

Translations strings are in `app/i18n/{lang}/` as PHP arrays, used with:

```php
_t('key.subkey')
```

## When to use this skill

- Adding new user-facing text to the application
- Moving/renaming or deleting existing translation keys
- Adding a new translation file for a new feature area
- Formatting translation files after manual edits

## Workflow example

When adding a new UI element:

1. Identify the appropriate i18n file and section, in proximity of existing strings, avoiding duplication
2. Add a key if an appropriate string does not already exist, using `cli/manipulate.translation.php` or the corresponding `make` commands as defined in the [instructions](../../instructions/i18n.instructions.md).
3. Use in the code:
	```php
	<button><?= _t('gen.action.my_new_button') ?></button>
	```
