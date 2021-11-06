Update CMSimple_XH
==================

* overwrite www/ with the new CMSimple_XH version

* put an empty `.gitignore` into `userfiles/media/`

Update PHP
==========

* replace the files in php/ with the new PHP version (use x64 NTS builds)

* do a phpize build of portable_xh_helper, and move the DLL into php/ext

* move php.ini-production into php/ as php.ini

* adjust php.ini
  * date.timezone = Europe/London
  * extension_dir = "ext"
  * extension=gd.dll
  * extension=mbstring
  * extension=sqlite3
  * extension=portable_xh_helper
  * zend_extension=php_opcache.dll
