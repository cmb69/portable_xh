Portable_XH
===========

Portable_XH is a portable CMSimple_XH distribution for Windows that is meant to
run on your local machine without the need to have a webserver with PHP
installed. It requires no installation, runs under a guest account and even from
an USB storage medium. It doesn't allow access from other computers,
particularly from the internet.

Portable_XH is the perfect solution to have a demo of CMSimple_XH at hand, or to
portably prepare a website without uploading it to some webspace in the first
place.

However, it is not meant to replace a local development environment. If you need
this, you should look for [XAMPP](http://www.apachefriends.org/en/xampp.html) or
any other of the major distributions.

Requirements
------------

64bit Windows Vista SP 2 or higher, with the 
[Visual C++ Redistributable for Visual Studio 2015 RC](https://www.microsoft.com/en-us/download/details.aspx?id=48145)
installed (you need the x64 version!)

Installation
------------

Just unzip the download to wherever you like – even to a USB storage medium.

Some functionality of CMSimple_XH and plugins requires to connect to the WWW,
for instance the link check. If you want to use these features, you have to
configure your firewall to allow outbound connections for
`Portable_XH\php\php.exe`. Usually your firewall will ask for this.

Usage
-----

Open `Portable_XH(.bat)` in the installation's top level folder. This will power
up the webserver and open the default browser pointing at the CMSimple_XH
installation. If you want to shut down the webserver just close the window. As
long as the webserver is running, you can navigate to <http://localhost:8080/>
to view the start page of the CMSimple_XH installation, which resides in the
`www/` subfolder.

You can log in via the login link at the bottom of the page. The default
password is "test".

How to use CMSimple_XH is described in its [Wiki](http://www.cmsimple-xh.org/wiki/doku.php>).
If you have questions feel free to ask in its [Forum](http://cmsimpleforum.com/).

Multiple CMSimple_XH Installations
----------------------------------

You can have multiple CMSimple_XH installations in a single Portable_XH the same
way as on any webserver, i.e. in different subfolders of the webroot. If the
webroot contains neither an `index.php` nor an `index.html`, Portable_XH will
display a menu of all immediate subfolders for easy navigation when started.

Email
-----

None of the emails that may be sent by CMSimple_XH or a plugin will actually
be sent. Instead all emails are stored in the `mails/` folder. If you have an
email client installed and configured which can handle external `.eml` files, you
can simply open the `.eml` files to view them; otherwise you'll want to import
them into your software.

License
-------

As this distribution is an aggregation of different pieces of software, the
folders contain independent software which is licensed separately as such.

* `/` (without subfolders)  
    Copyright (c) 2020 Christoph M. Becker  
    Licensed under [MIT License](http://opensource.org/licenses/MIT)  
    Website: <http://3-magi.net/?CMSimple_XH/Portable_XH>

* `php/` (incl. subfolders)  
    Copyright (c) 1997-2017 The PHP Group  
    Licensed under [PHP License 3.01](http://www.php.net/license/3_01.txt)  
    Website: <http://www.php.net/>

* `www/` (incl. subfolders)  
    Copyright (c) 1999-2009 Peter Harteg  
    Copyright (c) 2009-2019 The CMSimple_XH Developers  
    Licensed under [GNU GPLv3](http://www.gnu.org/licenses/gpl.html)  
    Website: <http://www.cmsimple-xh.org/>

Limitations
-----------

The distributed PHP build only contains a subset of the extensions that are
contained in the official PHP builds, because several extensions are most likely
never needed for CMSimple_XH websites, and too keep the download size small. If
you need other extensions, download a binary distribution (Zip) from
<http://windows.php.net/download/>, and put it in the `php/` folder of
Portable_XH. You may have to enable additional extensions in `php/php.ini`. Note
that it doesn't matter which PHP version and variant you download, but for best
compatibility VC14 or VC15 x64 Non Thread Safe variants are recommended.

PHP's built-in webserver, which is used by Portable_XH, is single-threaded. Thus
it can't handle nested requests, and such requests will block. In CMSimple_XH
currently the only such case is the check whether certain files can't be
accessed directly via HTTP. Since this check is unnecessary for Portable_XH,
this particular functionality is overriden (outside of the `www/` directory), so
no blocking will happen. However, some plugins may also utilize nested requests,
i.e. they may block resulting in a timeout error.

Due to a [bug in PHP's built-in webserver](https://bugs.php.net/bug.php?id=74061)
folders with dots in the name are regarded as files, so subfolders of `www/` must
not contain dots.

Some browsers (e.g. Opera 12.16) may not be able to navigate to
<http://localhost:8080/> for whatever reasons.  You most likely can get around
this issue by navigating to <http://[::1]:8080/> or <http://127.0.0.1:8080/>
manually.

Credits
-------

The application icon is designed by [Teekatas S. aka. Raindropmemory](http://raindropmemory.deviantart.com/).
Many thanks for making this icon freely available.
