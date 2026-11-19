---
applyTo: "**/*.js"
description: Editing JavaScript files
---

# JavaScript files

* Obey formatting rules defined in [`eslint.config.js`](../../eslint.config.js)
* Automatic fixes can be done with:
	```sh
	npm run eslint_fix
	# or (targeting more than just JavaScript)
	make fix-all
	```
* Validation can be done with:
	```sh
	npm run eslint
	# or (targeting more than just JavaScript)
	make test-all
	```
* Check [`package.json`](../../package.json) scripts for details about available individual commands.
