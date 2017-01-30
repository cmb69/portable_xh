Update CMSimple_XH
==================

* overwrite www/ with the new CMSimple_XH version

* fix XH_isAccessProtected() for the single threaded webserver

Update PHP
==========

* do a custom build of PHP:
  `configure --disable-all --disable-zts --enable-cli --enable-session --enable-json --with-gd --enable-mbstring --with-iconv --with-libxml --with-simplexml --with-xml --with-dom`

* put the compiled php.exe and php7.dll into php/

* put LICENSE into php/

* put php.ini-production into php/ as php.ini

* adjust php.ini
  * date.timezone = UTC
  * sendmail_path = ..\php\php.exe ..\storemail.php
