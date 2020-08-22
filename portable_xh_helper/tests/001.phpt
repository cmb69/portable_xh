--TEST--
Check if portable_xh_helper is loaded
--SKIPIF--
<?php
if (!extension_loaded('portable_xh_helper')) {
	echo 'skip';
}
?>
--FILE--
<?php
echo 'The extension "portable_xh_helper" is available';
?>
--EXPECT--
The extension "portable_xh_helper" is available
