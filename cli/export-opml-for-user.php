#!/usr/bin/env php
<?php
declare(strict_types=1);

use FreshRss\Models\Context;
use FreshRss\Services\ExportService;

require __DIR__ . '/_cli.php';

performRequirementCheck(Context::systemConf()->db['type'] ?? '');

$cliOptions = new class extends CliOptionsParser {
	public string $user;

	public function __construct() {
		$this->addRequiredOption('user', (new CliOption('user')));
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

$username = cliInitUser($cliOptions->user);

fwrite(STDERR, 'FreshRSS exporting OPML for user “' . $username . "”…\n");

$export_service = new ExportService($username);
[$filename, $content] = $export_service->generateOpml();
echo $content;

invalidateHttpCache($username);

done();
