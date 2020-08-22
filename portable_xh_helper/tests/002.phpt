--TEST--
XH_isAccessProtected() can be pre-defined
--SKIPIF--
<?php
if (!extension_loaded('portable_xh_helper')) {
	echo 'skip';
}
?>
--FILE--
<?php
require_once __DIR__ . '/002.inc.php';

function XH_isAccessProtected()
{
	return true;
}

var_dump(XH_isAccessProtected());
?>
--EXPECT--
bool(true)
