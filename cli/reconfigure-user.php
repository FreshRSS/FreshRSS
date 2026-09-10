#!/usr/bin/env php
<?php
declare(strict_types=1);
require __DIR__ . '/_cli.php';

$cliOptions = new class extends CliOptionsParser {
	public string $user;
	public string $key;
	public string $value;
	public bool $list;
	public bool $set;
	public bool $unset;
	public bool $valueStdin;
	public bool $force;
	public bool $showSecrets;

	public function __construct() {
		$this->addRequiredOption('user', (new CliOption('user')));
		$this->addOption('key', (new CliOption('key')));
		$this->addOption('value', (new CliOption('value')));
		$this->addOption('list', (new CliOption('list'))->withValueNone());
		$this->addOption('set', (new CliOption('set'))->withValueNone());
		$this->addOption('unset', (new CliOption('unset'))->withValueNone());
		$this->addOption('valueStdin', (new CliOption('value-stdin'))->withValueNone());
		$this->addOption('force', (new CliOption('force'))->withValueNone());
		$this->addOption('showSecrets', (new CliOption('show-secrets'))->withValueNone());
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

$hasList = $cliOptions->list;
$hasSet = $cliOptions->set;
$hasUnset = $cliOptions->unset;
$hasStdin = $cliOptions->valueStdin;
$force = $cliOptions->force;
$showSecrets = $cliOptions->showSecrets;
$hasKey = ($cliOptions->key ?? '') !== '';
$hasValue = ($cliOptions->value ?? '') !== '';

if ($hasList && ($hasSet || $hasUnset || $hasKey)) {
	fail('FreshRSS error: --list cannot be combined with --key, --set, or --unset' . "\n" . $cliOptions->usage);
}
if (!$hasList && !$hasKey) {
	fail('FreshRSS error: --list or --key is required' . "\n" . $cliOptions->usage);
}
if ($hasSet && $hasUnset) {
	fail('FreshRSS error: --set and --unset are mutually exclusive' . "\n" . $cliOptions->usage);
}
if ($hasSet && $hasValue && $hasStdin) {
	fail('FreshRSS error: --value and --value-stdin are mutually exclusive' . "\n" . $cliOptions->usage);
}
if ($hasSet && !$hasValue && !$hasStdin) {
	fail('FreshRSS error: --set requires --value or --value-stdin' . "\n" . $cliOptions->usage);
}

$username = cliInitUser($cliOptions->user);
$userConf = FreshRSS_Context::userConf();

function isSecretKey(string $key): bool {
	return (bool) preg_match('/(hash|key|password|token|secret)$/i', $key);
}

function formatValue(mixed $v): string {
	if (is_array($v)) {
		return (string) json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}
	if (is_bool($v)) {
		return $v ? 'true' : 'false';
	}
	if (!is_scalar($v)) {
		return '';
	}
	return (string) $v;
}

if ($hasList) {
	$allData = $userConf->toArray();
	ksort($allData);
	foreach ($allData as $k => $v) {
		$display = !$showSecrets && isSecretKey($k) && $v !== '' ? '***' : formatValue($v);
		echo $k, '=', $display, "\n";
	}
	done();
}

$key = $cliOptions->key;
if ($key === '') {
	fail('FreshRSS error: --key cannot be empty' . "\n" . $cliOptions->usage);
}

if (!$hasSet && !$hasUnset) {
	if (!$userConf->hasParam($key)) {
		fail('FreshRSS error: key not found: ' . $key, 2);
	}
	echo formatValue($userConf->toArray()[$key] ?? null), "\n";
	done();
}

if ($hasUnset) {
	if (!$userConf->hasParam($key)) {
		fail('FreshRSS error: key not found: ' . $key, 2);
	}
	$userConf->_attribute($key, null);
	done($userConf->save());
}

if (!$userConf->hasParam($key) && !$force) {
	fail('FreshRSS error: unknown key "' . $key . '". Use --force to set it anyway, or use the "extensions" sub-key for extension-specific config.');
}

$rawValue = $hasStdin
	? rtrim((string) stream_get_contents(STDIN), "\n\r")
	: $cliOptions->value;

if ($userConf->hasParam($key)) {
	$existing = $userConf->toArray()[$key] ?? null;
	if (is_array($existing)) {
		fail('FreshRSS error: key "' . $key . '" is an array type and cannot be set via CLI');
	} elseif (is_bool($existing)) {
		$typed = filter_var($rawValue, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
		if ($typed === null) {
			fail('FreshRSS error: key "' . $key . '" expects a boolean value (true/false/1/0)');
		}
	} elseif (is_int($existing)) {
		if (!ctype_digit(ltrim($rawValue, '-'))) {
			fail('FreshRSS error: key "' . $key . '" expects an integer value');
		}
		$typed = (int) $rawValue;
	} else {
		$typed = $rawValue;
	}
} else {
	$lower = strtolower($rawValue);
	if (in_array($lower, ['true', 'false'], true)) {
		$typed = $lower === 'true';
	} elseif ($rawValue !== '' && ctype_digit(ltrim($rawValue, '-'))) {
		$typed = (int) $rawValue;
	} else {
		$typed = $rawValue;
	}
}

$userConf->_attribute($key, $typed);
done($userConf->save());
