#!/usr/bin/env bash
set -euo pipefail

script_dir=$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)
translator="$script_dir/../../Docker/rootless-cron.sh"
tests_run=0

fail() {
	echo "FAIL: $*" >&2
	exit 1
}

assert_translation() {
	local expression=$1 expected=$2 actual
	if ! actual=$(bash "$translator" --translate "$expression" 2>/dev/null); then
		fail "CRON_MIN '$expression' was rejected; expected '$expected'"
	fi
	if [[ $actual != "$expected" ]]; then
		fail "CRON_MIN '$expression' translated to '$actual'; expected '$expected'"
	fi
	((tests_run += 1))
}

assert_rejected() {
	local expression=$1 output
	if output=$(bash "$translator" --translate "$expression" 2>&1); then
		fail "CRON_MIN '$expression' was accepted; expected rejection"
	fi
	if [[ $output != *'FreshRSS scheduler:'* ]]; then
		fail "CRON_MIN '$expression' failed without a scheduler diagnostic: $output"
	fi
	((tests_run += 1))
}

# Single values, lists, ranges, steps, leading zeroes, and union semantics.
assert_translation '0' '0'
assert_translation '59' '59'
assert_translation '1,31' '1,31'
assert_translation '5-9' '5,6,7,8,9'
assert_translation '5-10/2' '5,7,9'
assert_translation '*/15' '0,15,30,45'
assert_translation '1/20' '1,21,41'
assert_translation '07,00-05/02' '0,2,4,7'
assert_translation '5,1-3/2,*/30' '0,1,3,5,30'

# Empty/malformed fields, invalid bounds, descending ranges, and zero steps.
assert_rejected ''
assert_rejected '1,,2'
assert_rejected ',1'
assert_rejected '1,'
assert_rejected 'abc'
assert_rejected '60'
assert_rejected '5-60'
assert_rejected '9-5'
assert_rejected '*/0'
assert_rejected '*/60'
assert_rejected '5/abc'
assert_rejected '*/2/3'

echo "Passed $tests_run rootless CRON_MIN translation tests."
