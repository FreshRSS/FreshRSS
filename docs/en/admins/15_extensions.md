# Extensions

Not every feature is relevant for all users, but some special features are relevant to the right person. That is why FreshRSS is extendable.

There are some "official" extensions (supported and published by the FreshRSS development team and community) and "community" extensions (developed and published individually by third-party developers).

## Extension repositories

Most known extensions are listed in the front end: see configuration menu `Configuration/Extensions`.

## How to install

Upload the folder (f.e. `CustomCSS`) of your chosen extension into your `./extensions` directory.

Result: Content of `./extensions/CustomCSS/` has f.e. `extension.php`, `metadata.json`, `configure.php`, `README.md` files and the folders `i18n` and `static`

Important: Do not delete or overwrite the existing files `./extensions/.gitignore` and `./extensions/README.md` 

## How to enable/disable and manage

See in the front end: configuration menu `Configuration/Extensions`

### User extensions

Every user has to manage the extensions by them self. The configuration via the cog icon is valid only for the user, not for other users. 

`metadata.json`: "type": "user"

### System extensions

Only administrators can enabled/disable system extensions. The configuration via the cog icon is valid for every user. 

`metadata.json`: "type": "system"

### pre installed extensions (core extensions)

See folder: `.lib/core-extensions`

2 system extensions are already pre installed: `Google-Groups` and `Tumblr-GDPR`.

Important: Do not install you chosen extensions here!