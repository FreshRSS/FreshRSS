<?php

if (PHP_INT_SIZE < 8) {	//32-bit
	function dec2hex($dec) {
		return str_pad(gmp_strval(gmp_init($dec, 10), 16), 16, '0', STR_PAD_LEFT);
	}
	function hex2dec($hex) {
		if (!ctype_xdigit($hex)) return 0;
		return gmp_strval(gmp_init($hex, 16), 10);
	}
} else {	//64-bit
	function dec2hex($dec) {	//http://code.google.com/p/google-reader-api/wiki/ItemId
		return str_pad(dechex($dec), 16, '0', STR_PAD_LEFT);
	}
	function hex2dec($hex) {
		if (!ctype_xdigit($hex)) return 0;
		return hexdec($hex);
	}
}
