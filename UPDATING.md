Update CMSimple_XH
==================

* overwrite www/ with the new CMSimple_XH version

* put an empty `.gitignore` into `userfiles/media/`

Update PHP
==========

* do a custom build of PHP:
  `configure --disable-all --disable-zts --enable-cli --enable-session --enable-json --with-iconv --with-libxml --with-simplexml --with-dom --enable-filter --enable-bcmath --enable-calendar --enable-zip --enable-zlib --with-gd=shared --enable-mbstring=shared --with-sqlite3=shared
  --enable-uopz=shared`

* move relevant files from snapshot to php/

* move php.ini-production into php/ as php.ini

* adjust php.ini
  * date.timezone = Europe/London
  * extension_dir = "ext"
  * extension=php_gd2.dll
  * extension=php_mbstring.dll
  * extension=php_sqlite3.dll
  * extension=php_uopz.dll
  * zend_extension=php_opcache.dll
