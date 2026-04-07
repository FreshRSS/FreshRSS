#!/usr/bin/env php
<?php
declare(strict_types=1);
require_once __DIR__ . '/_cli.php';
require_once __DIR__ . '/i18n/PluralFormsCompiler.php';

$cliOptions = new class extends CliOptionsParser {
	public bool $all;
	public string $file;
	public string $formula;
	public bool $help;

	public function __construct() {
		$this->addOption('all', (new CliOption('all', 'a'))->withValueNone());
		$this->addOption('file', new CliOption('file', 'f'));
		$this->addOption('formula', new CliOption('formula', 'p'));
		$this->addOption('help', (new CliOption('help', 'h'))->withValueNone());
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}
if ($cliOptions->help || (!isset($cliOptions->formula) && !isset($cliOptions->file) && !$cliOptions->all)) {
	compilePluralsHelp();
}

$compiler = new PluralFormsCompiler();

if (isset($cliOptions->formula)) {
	echo $compiler->compileFormulaToLambda($cliOptions->formula) . "\n";
	done();
}

if (isset($cliOptions->file)) {
	$compiler->compileFile($cliOptions->file);
	echo 'Compiled ' . $cliOptions->file . "\n";
	done();
}

$changed = $compiler->compileAll();
echo 'Compiled ' . $changed . " plural file(s).\n";
done();

function compilePluralsHelp(): never {
	$file = str_replace(__DIR__ . '/', '', __FILE__);

	echo <<<HELP
NAME
	$file

SYNOPSIS
	php $file [ --all | --file=<path> | --formula='<plural-forms>' ]

DESCRIPTION
	Compile gettext plural formulas into PHP callables for runtime consumption.

	-a, --all		compile all app/i18n/*/plurals.php files in place.
	-f, --file=FILE		compile a single plural file in place.
	-p, --formula=FORMULA	output the compiled PHP lambda for a gettext plural formula.
	-h, --help		display this help and exit.

EXAMPLES
	php $file --formula 'nplurals=2; plural=(n != 1);'
	php $file --file app/i18n/en/plurals.php
	php $file --all

REFERENCES
	https://www.gnu.org/software/gettext/manual/html_node/Plural-forms.html
	https://docs.translatehouse.org/projects/localization-guide/en/latest/l10n/pluralforms.html
HELP, PHP_EOL;
	exit();
}
