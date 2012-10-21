<?php
// tiré de Shaarli de Seb Sauvage
function small_hash ($txt) {

    $t = rtrim (base64_encode (hash ('crc32', $txt, true)), '=');
    $t = str_replace ('+', '-', $t); // Get rid of characters which need encoding in URLs.
    $t = str_replace ('/', '_', $t);
    $t = str_replace ('=', '@', $t);
    
    return $t;
}

function timestamptodate ($t, $hour = true) {
	$jour = date ('d', $t);
	$mois = date ('m', $t);
	$annee = date ('Y', $t);
	
	switch ($mois) {
	case 01:
		$mois = 'janvier';
		break;
	case 02:
		$mois = 'février';
		break;
	case 03:
		$mois = 'mars';
		break;
	case 04:
		$mois = 'avril';
		break;
	case 05:
		$mois = 'mai';
		break;
	case 06:
		$mois = 'juin';
		break;
	case 07:
		$mois = 'juillet';
		break;
	case 08:
		$mois = 'août';
		break;
	case 09:
		$mois = 'septembre';
		break;
	case 10:
		$mois = 'octobre';
		break;
	case 11:
		$mois = 'novembre';
		break;
	case 12:
		$mois = 'décembre';
		break;
	}
	
	$date = $jour . ' ' . $mois . ' ' . $annee;
	if ($hour) {
		return $date . date (' \à H\:i', $t);
	} else {
		return $date;
	}
}

function sortEntriesByDate ($entry1, $entry2) {
	return $entry2->date (true) - $entry1->date (true);
}
