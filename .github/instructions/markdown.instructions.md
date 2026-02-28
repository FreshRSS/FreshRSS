---
applyTo: "**/*.md"
description: Editing Markdown
---

# Markdown files

* Obey formatting rules defined in [`.markdownlint.json`](../../.markdownlint.json)
* For fenced code blocks:
	* Use language identifiers as much as possible, e.g., `php`, `js`, `css`
	* Favour `sh` over `bash`
* Automatic fixes can be done with:
	```sh
	npm run markdownlint_fix
	```
* Validation can be done with:
	```sh
	npm run markdownlint
	```
