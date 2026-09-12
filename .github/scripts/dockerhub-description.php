#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * Build the Docker Hub description from Docker/README.md.
 *
 * Docker Hub caps a repository's full description at 25,000 characters and
 * peter-evans/dockerhub-description simply cuts at the limit, which lands
 * mid-section and makes the documentation look unfinished (#9211).
 *
 * So cut it ourselves, at a heading rather than at a character, and say so
 * with a link to the rest.
 *
 * Usage: php .github/scripts/dockerhub-description.php <in.md> <out.md>
 */

/**
 * peter-evans/dockerhub-description truncates to 25,000 *bytes*, not
 * characters (`utils.truncateToBytes`), so count bytes here too or a README
 * with emoji in it would still be cut by the action.
 */
const DOCKER_HUB_LIMIT = 25000;

const SOURCE_URL = 'https://github.com/FreshRSS/FreshRSS/blob/edge/Docker/README.md';

/**
 * Headings inside a fenced code block are shell comments, not headings, and
 * this README is full of them.
 */
function isHeading(string $line, bool $insideFence): bool {
	return !$insideFence && str_starts_with($line, '## ');
}

function isFence(string $line): bool {
	return str_starts_with(ltrim($line), '```');
}

/** @return list<string> */
function truncateAtHeading(string $markdown, int $budget): array {
	$lines = explode("\n", $markdown);
	$insideFence = false;
	$kept = [];
	$lastSafeCut = null;
	$length = 0;

	foreach ($lines as $line) {
		if (isHeading($line, $insideFence) && $length <= $budget) {
			// A heading we could stop just before, with everything so far fitting.
			$lastSafeCut = count($kept);
		}
		if (isFence($line)) {
			$insideFence = !$insideFence;
		}
		$kept[] = $line;
		$length += strlen($line) + 1;
	}

	if ($lastSafeCut === null) {
		// No heading fits; fall back to whole lines, which at least never cuts
		// a word or a link in half.
		$lastSafeCut = 0;
		$length = 0;
		foreach ($lines as $index => $line) {
			$length += strlen($line) + 1;
			if ($length > $budget) {
				break;
			}
			$lastSafeCut = $index + 1;
		}
	}

	return array_slice($kept, 0, $lastSafeCut);
}

function footer(): string {
	return implode("\n", [
		'',
		'---',
		'',
		'📖 **This description is shortened to fit Docker Hub\'s 25,000-character limit.**',
		'',
		'[**Read the full documentation on GitHub →**](' . SOURCE_URL . ')',
		'',
	]);
}

$source = $argv[1] ?? 'Docker/README.md';
$target = $argv[2] ?? null;
if ($target === null) {
	fwrite(STDERR, "Usage: dockerhub-description.php <in.md> <out.md>\n");
	exit(1);
}

$markdown = file_get_contents($source);
if ($markdown === false) {
	fwrite(STDERR, "Cannot read $source\n");
	exit(1);
}

$total = strlen($markdown);
if ($total <= DOCKER_HUB_LIMIT) {
	// Nothing to do; keep the description byte-identical to the README so this
	// step disappears on its own if the README ever shrinks again.
	file_put_contents($target, $markdown);
	fwrite(STDERR, "Docker Hub description: $total bytes, under the limit, passed through unchanged.\n");
	exit(0);
}

$foot = footer();
$budget = DOCKER_HUB_LIMIT - strlen($foot);
$kept = truncateAtHeading($markdown, $budget);
$out = rtrim(implode("\n", $kept), "\n") . "\n" . $foot;

$final = strlen($out);
if ($final > DOCKER_HUB_LIMIT) {
	fwrite(STDERR, "Truncation produced $final bytes, over the limit\n");
	exit(1);
}

file_put_contents($target, $out);
fwrite(STDERR, "Docker Hub description: $total bytes truncated to $final, cut at a heading.\n");
