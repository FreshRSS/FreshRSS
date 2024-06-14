# Libraries

## Updating libraries

Some of the libraries in this folder can be updated semi-automatically by invoking:

```sh
cd ./FreshRSS/lib/
composer update --no-autoloader
```

Remember to read the change-logs, proof-read the changes, preserve possible local patches, add irrelevant files to [`.gitignore`](.gitignore) (minimal installation), and test before committing.
