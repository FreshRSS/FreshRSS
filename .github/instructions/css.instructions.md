---
applyTo: "**/*.css"
description: Editing CSS files
---

# CSS files

* Obey formatting rules defined in [`.stylelintrc.json`](../../.stylelintrc.json)
* Automatic fixes can be done with:
	```sh
	npm run stylelint_fix
	# or (targeting more than just CSS)
	make fix-all
	```
* Validation can be done with:
	```sh
	npm run stylelint
	# or (targeting more than just CSS)
	make test-all
	```

## Right-to-left CSS files

* Do not edit RTL CSS `*.rtl.css` files manually.
* RTL CSS files are auto-generated from LTR CSS files using the `rtlcss` tool.
* Run the following command to regenerate the RTL files:
	```sh
	npm run rtlcss
	# or
	make rtl
	```
