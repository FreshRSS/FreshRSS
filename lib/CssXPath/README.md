Translate CSS selectors to XPath queries.
=========================================

A lightweight and dependency free CSS to XPath translator. This repository is used to bring modern DOM functionality like [`querySelectorAll()`][qsa] to PHP in the [PHP.Gt/Dom][gt-dom] project.

***

<a href="https://github.com/PhpGt/CssXPath/actions" target="_blank">
	<img src="https://badge.status.php.gt/cssxpath-build.svg" alt="Build status" />
</a>
<a href="https://scrutinizer-ci.com/g/PhpGt/CssXPath" target="_blank">
	<img src="https://badge.status.php.gt/cssxpath-quality.svg" alt="Code quality" />
</a>
<a href="https://scrutinizer-ci.com/g/PhpGt/CssXPath" target="_blank">
	<img src="https://badge.status.php.gt/cssxpath-coverage.svg" alt="Code coverage" />
</a>
<a href="https://packagist.org/packages/PhpGt/CssXPath" target="_blank">
	<img src="https://badge.status.php.gt/cssxpath-version.svg" alt="Current version" />
</a>
<a href="http://www.php.gt/cssxpath" target="_blank">
	<img src="https://badge.status.php.gt/cssxpath-docs.svg" alt="PHP.Gt/CssXPath documentation" />
</a>

Example usage
-------------


```php
use Gt\CssXPath\Translator;

$html = <<<HTML
<form>
	<label>
		Name
		<input name="name" />
	</label>
	<label>
		Code:
		<input name="code" />
	</label>
	<button name="do" value="submit">Submit code</button>
</form>
HTML;

$document = new DOMDocument();
$document->loadHTML($html);

$xpath = new DOMXPath($document);
$inputElementList = $xpath->query(new Translator("form>label>input");
```

[qsa]: https://developer.mozilla.org/en-US/docs/Web/API/Document/querySelectorAll
[gt-dom]: https://www.php.gt/dom
