# Libraries

## SimplePie

FreshRSS uses a forked version of [SimplePie](https://github.com/simplepie/simplepie), with a [number of patches](https://github.com/FreshRSS/simplepie/).

See the [read-me of our fork](https://github.com/FreshRSS/simplepie/blob/freshrss/.github/README.md).


## Updating libraries

Some of the libraries in this folder can be updated semi-automatically by invoking:

```sh
cd ./FreshRSS/lib/
composer update --no-autoloader
```

Remember to read the change-logs, proof-read the changes, preserve possible local patches, add irrelevant files to [`.gitignore`](.gitignore) (minimal installation), and test before committing.
