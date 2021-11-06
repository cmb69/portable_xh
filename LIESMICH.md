Portable_XH
===========

Portable_XH ist eine portable CMSimple_XH Distribution für Windows, die dazu
gedacht ist auf Ihrem lokalem PC ausgeführt zu werden, ohne die Notwendigkeit
einen Webserver mit PHP installiert zu haben. Es benötigt keine Installation,
kann unter einem Gast-Konto und selbst von einem USB-Speichermedium ausgeführt
werden. Es erlaubt keinen Zugriff von anderen Computern, besonders aus dem
Internet.

Portable_XH ist die perfekte Lösung um eine Demo von CMSimple_XH zur Hand zu
haben, oder um portabel eine Website vorzubereiten, ohne diese zunächst auf
einen Webspace hoch zu laden.

Allerdings ist es nicht dazu gedacht eine lokale Entwicklungsumgebung zu
ersetzen. Wenn Sie eine solche brauchen, sollten Sie sich [XAMPP](http://www.apachefriends.org/de/xampp.html) oder eine anderen der großen
Distributionen anschauen.

Voraussetzungen
---------------

64bit Windows 7 oder höher, auf dem das 
[Visual C++ Redistributable for Visual Studio 2015-2019](https://aka.ms/vs/16/release/VC_redist.x64.exe)
installiert ist.

Installation
------------

Entpacken Sie einfach den Download wohin Sie möchten – auch auf ein
USB-Speichermedium.

Einige Funktionen von CMSimple_XH und Plugins, z.B. der Link-Check, erfordern
eine Verbindung mit dem WWW. Wenn Sie diese Funktionen nutzen möchten, dann
müssen Sie Ihre Firewall so konfigurieren, dass ausgehende Verbindungen von
`Portable_XH\php\php.exe` erlaubt werden. Normalerweise wird die Firewall danach
fragen.

Verwendung
----------

Öffnen Sie `Portable_XH(.bat)` im Hauptverzeichnis der Installation. Dies startet
den Webserver und öffnet die CMSimple_XH Installation im Standardbrowser. Wenn
Sie den Webserver stoppen wollen, dann schließen sie dieses Fenster einfach. So
lange der Webserver läuft, können Sie <http://localhost:8080/> aufrufen, um zur
Startseite der CMSimple_XH Installation, die sich im `www/` Unterordner befindet,
zu gelangen.

Sie können sich über den login Link am Ende der Seite anmelden. Das
voreingestellte Passwort ist "test".

Wie CMSimple_XH verwendet wird, ist in seinem [Wiki](http://www.cmsimple-xh.org/wiki/doku.php) beschrieben. Wenn Sie Fragen haben,
zögern Sie nicht diese im [CMSimple_XH Forum](http://cmsimpleforum.com/) zu
stellen.

Mehrere CMSimple_XH Installationen
----------------------------------

Sie können in einem einzigen Portable_XH mehrere CMSimple_XH Installationen
haben; das funktioniert genau wie bei anderen Webservern auch, d.h. die
Installationen müssen sich in unterschiedlichen Unterordnern des Webroot
befinden. Wenn das Webroot weder eine `index.php` noch eine `index.html` enthält,
dann zeigt Portable_XH ein Menü aller direkten Unterordner zur leichten
Navigation an, wenn es gestartet wird.

E-Mail
------

Keine der E-Mails die ggf. von CMSimple_XH oder einem Plugin versendet werden,
wird tatsächlich verschickt. Statt dessen werden alle E-Mails im `mails/` Ordner
gespeichert. Wenn Sie ein E-Mail-Programm als Standard E-Mail-Programm
eingerichtet haben, das externe `.eml` Dateien öffnen kann, können Sie die `.eml`
Dateien einfach öffnen, um die E-Mail einzusehen; ansonsten können sie die `.eml`
Dateien in Ihr Programm importieren.

Lizenz
------

Da diese Distribution eine Aggregation verschiedener Programme ist, enthalten
die Ordner unabhängige Software, die als solche getrennt lizensiert ist.

* `/` (ohne Unterordner)  
    Copyright (c) 2020 Christoph M. Becker  
    Lizensiert unter der [MIT Lizenz](http://opensource.org/licenses/MIT)  
    Website: <http://3-magi.net/?CMSimple_XH/Portable_XH>

* `php/` (inkl. Unterordnern)
    Copyright (c) 1997-2015 The PHP Group  
    Lizensiert unter der [PHP License 3.01](http://www.php.net/license/3_01.txt)  
    Website: <http://www.php.net/>

* `www/` (inkl. Unterordnern)
    Copyright (c) 1999-2009 Peter Harteg  
    Copyright (c) 2009-2019 The CMSimple_XH Developers  
    Lizensiert unter der [GNU GPLv3](http://www.gnu.org/licenses/gpl.html)  
    Website: <http://www.cmsimple-xh.org/>

Beschränkungen
--------------

Der ausgelieferte PHP-Build enthält nur einen Teil der Extensions, die in den
offiziellen PHP-Builds enthalten sind, weil einige Extensions vermutlich nie für
CMSimple_XH Websites benötigt werden, und um die Downloadgröße im Rahmen zu
halten. Werden weitere Extensions benötigt, kann eine Binärdistribution (Zip)
von <http://windows.php.net/download/> herunter geladen, und in den `php/` Ordner
von Portable_XH entpackt werden. Unter Umständen müssen zusätzliche Erweiterung
in `php/php.ini` aktiviert werden. Es ist zu beachten, dass es keine Rolle spielt,
welche PHP-Version herunter geladen wird, aber für beste
Kompatibilität werden VC15 oder VS16 x64 Non Thread Safe Varianten empfohlen.
Weiterhin sollte `php/ext/php_portable_xh_helper.dll` mit einer Kopie der DLL
für die gewählte PHP-Version überschrieben werden.

Der eingebaute Webserver von PHP, der von Portable_XH verwendet wird, ist
single-threaded. Daher kann er keine verschachtelten Anfrage bearbeiten, und
solche Anfrage werden blockieren. In CMSimple_XH ist derzeit der einzige
entsprechende Fall die Prüfung, ob auf bestimmte Dateien direkt per HTTP
zugegriffen werden kann. Da diese Prüfung für Portable_XH unnötig ist, wird
diese spezielle Funktionalität übersteuert (außerhalb des `www/` Verzeichnisses),
so dass die Anwendung nicht blockiert. Allerdings können einige Plugins
ebenfalls solch verschachtelte Anfragen ausführen, d.h. sie können blockieren,
was in einem Timeout-Error resultiert.

Aufgrund eines [Fehlers in eingebauten Webserver von PHP](https://bugs.php.net/bug.php?id=74061)
werden Ordner mit Punkten im Namen als Dateien angesehen, so dass Unterordner von
`www/` keine Punkte enthalten dürfen.

Manche Browser (z.B. Opera 12.16) können aus welchen Gründen auch immer
möglicherweise <http://localhost:8080/> nicht anzeigen. Sie können das
vermutlich aber umgehen, wenn Sie <http://[::1]:8080/> oder
<http://127.0.0.1:8080/> manuell aufrufen.

Danksagung
----------

Das Anwendungs-Icon wurde von 
[Teekatas S. aka. Raindropmemory](http://raindropmemory.deviantart.com/)
gestaltet. Vielen Dank für die freie Nutzbarkeit dieses Icons.
