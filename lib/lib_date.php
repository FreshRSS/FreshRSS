<?php
/**
 * Author: Alexandre Alapetite https://alexandre.alapetite.fr
 * 2014-06-01
 * License: GNU AGPLv3 http://www.gnu.org/licenses/agpl-3.0.html
 *
 * Parser of ISO 8601 time intervals http://en.wikipedia.org/wiki/ISO_8601#Time_intervals
 *	Examples: "2014-02/2014-04", "2014-02/04", "2014-06", "P1M"
 */

/*
example('2014-03');
example('201403');
example('2014-03-30');
example('2014-05-30T13');
example('2014-05-30T13:30');
example('2014-02/2014-04');
example('2014-02--2014-04');
example('2014-02/04');
example('2014-02-03/05');
example('2014-02-03T22:00/22:15');
example('2014-02-03T22:00/15');
example('2014-03/');
example('/2014-03');
example('2014-03/P1W');
example('P1W/2014-05-25T23:59:59');
example('P1Y/');
example('P1Y');
example('P2M/');
example('P3W/');
example('P4D/');
example('PT5H/');
example('PT6M/');
example('PT7S/');
example('P1DT1H/');

function example($dateInterval) {
	$dateIntervalArray = parseDateInterval($dateInterval);
	echo $dateInterval, "\t=>\t",
		$dateIntervalArray[0] == null ? 'null' : @date('c', $dateIntervalArray[0]), '/',
		$dateIntervalArray[1] == null ? 'null' : @date('c', $dateIntervalArray[1]), "\n";
}
*/

function _dateFloor($isoDate) {
	$x = explode('T', $isoDate, 2);
	$t = isset($x[1]) ? str_pad($x[1], 6, '0') : '000000';
	return str_pad($x[0], 8, '01') . 'T' . $t;
}

function _dateCeiling($isoDate) {
	$x = explode('T', $isoDate, 2);
	$t = isset($x[1]) && strlen($x[1]) > 1 ? str_pad($x[1], 6, '59') : '235959';
	switch (strlen($x[0])) {
		case 4:
			return $x[0] . '1231T' . $t;
		case 6:
			$d = @strtotime($x[0] . '01');
			return $x[0] . date('t', $d) . 'T' . $t;
		default:
			return $x[0] . 'T' . $t;
	}
}

function _noDelimit($isoDate) {
	return $isoDate === null || $isoDate === '' ? null : str_replace(array('-', ':'), '', $isoDate);	//FIXME: Bug with negative time zone
}

function _dateRelative($d1, $d2) {
	if ($d2 === null) {
		return $d1 !== null && $d1[0] !== 'P' ? $d1 : null;
	} elseif ($d2 !== '' && $d2[0] != 'P' && $d1 !== null && $d1[0] !== 'P') {
		$y2 = substr($d2, 0, 4);
		if (strlen($y2) < 4 || !ctype_digit($y2)) {	//Does not start by a year
			$d2 = _noDelimit($d2);
			return substr($d1, 0, -strlen($d2)) . $d2;	//Add prefix from $d1
		}
	}
	return _noDelimit($d2);
}

/**
 * Parameter $dateInterval is a string containing an ISO 8601 time interval.
 * Returns an array with the minimum and maximum Unix timestamp of this interval,
 *  or null if open interval, or false if error.
 */
function parseDateInterval($dateInterval) {
	$dateInterval = trim($dateInterval);
	$dateInterval = str_replace('--', '/', $dateInterval);
	$dateInterval = strtoupper($dateInterval);
	$min = null;
	$max = null;
	$x = explode('/', $dateInterval, 2);
	$d1 = _noDelimit($x[0]);
	$d2 = _dateRelative($d1, count($x) > 1 ? $x[1] : null);
	if ($d1 !== null && $d1[0] !== 'P') {
		$min = @strtotime(_dateFloor($d1));
	}
	if ($d2 !== null) {
		if ($d2[0] === 'P') {
			try {
				$di2 = new DateInterval($d2);
				$dt1 = @date_create();	//new DateTime() would create an Exception if the default time zone is not defined
				if ($min !== null && $min !== false) {
					$dt1->setTimestamp($min);
				}
				$max = $dt1->add($di2)->getTimestamp() - 1;
			} catch (Exception $e) {
				$max = false;
			}
		} elseif ($d1 === null || $d1[0] !== 'P') {
			$max = @strtotime(_dateCeiling($d2));
		} else {
			$max = @strtotime($d2);
		}
	}
	if ($d1 !== null && $d1[0] === 'P') {
		try {
			$di1 = new DateInterval($d1);
			$dt2 = @date_create();
			if ($max !== null && $max !== false) {
				$dt2->setTimestamp($max);
			}
			$min = $dt2->sub($di1)->getTimestamp() + 1;
		} catch (Exception $e) {
				$min = false;
		}
	}
	return array($min, $max);
}
