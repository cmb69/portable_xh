<?php

/* utf8-marker = äöü */
/*
  ======================================
  CMSimple_XH 1.5.3
  2012-03-19
  based on CMSimple version 3.3 - December 31. 2009
  For changelog, downloads and information please see http://www.cmsimple-xh.com
  ======================================
  -- COPYRIGHT INFORMATION START --

  CMSimple version 3.3 - December 31. 2009
  Small - simple - smart
  © 1999-2009 Peter Andreas Harteg - peter@harteg.dk

  -- COPYRIGHT INFORMATION END --

  -- LICENCE TYPES SECTION START --

  CMSimple is available under four different licenses:

  1) GPL 3
  From December 31. 2009 CMSimple is released under the GPL 3 licence with no link requirments. You may not remove copyright information from the files, and any modifications will fall under the copyleft conditions in the GPL 3.

  2) AGPL 3
  You must keep a convenient and prominently visible feature on every generated page that displays the CMSimple Legal Notices. The required link to the CMSimple Legal Notices must be static, visible and readable, and the text in the CMSimple Legal Notices may not be altered.
  See http://www.cmsimple.org/?Licence:CMSimple_Legal_Notices

  3) Linkware / CMSimple Link Requirement Licence
  Same as AGPL, but instead of keeping a link to the CMSimple Legal Notices, you must place a static, visible and readable link to www.cmsimple.org with the text or an image stating "Powered by CMSimple" on every generated page (place it in the template).
  See http://www.cmsimple.org/?Licence:CMSimple_Link_Requirement_Licence

  4) Commercial Licence
  This licence will allow you to remove the CMSimple Legal Notices / "Powered by CMSimple"-link at one specific domain. This licence will also protect your modifications against the copyleft requirements in AGPL 3 and give access to registering in user support forum.

  You may change this LICENCE TYPES SECTION to relevant information, if you have purchased a commercial licence, but then the files may not be distributed to any other domain not covered by a commercial licence.

  For further informaion about the licence types, please see http://www.cmsimple.org/?Licence and /cmsimple/legal.txt

  -- LICENCE TYPES SECTION END -
  ======================================
 */

$title = '';
$o = '';
$e = '';
$hjs = '';
$onload = '';

// added to make it possible to overwrite the backend plugins delivered with the core

//$backend_hooks = array(
//  'pagemanager' => false,
//  'filebrowser' => false
//);

//HI 2009-10-30 (CMSimple_XH 1.0rc3) added version-informations
define('CMSIMPLE_XH_VERSION', 'CMSimple_XH 1.5.3');
define('CMSIMPLE_XH_BUILD', 2012031901);
define('CMSIMPLE_XH_DATE', '2012-03-19');
//version-informations

if (preg_match('/cms.php/i', sv('PHP_SELF')))
    die('Access Denied');

$pth['file']['execute'] = './index.php';
$pth['folder']['content'] = './content/';
$pth['file']['content'] = $pth['folder']['content'] . 'content.htm';
$pth['file']['pagedata'] = $pth['folder']['content'] . 'pagedata.php';

if (@is_dir('./cmsimple/'))
    $pth['folder']['base'] = './';
else
    $pth['folder']['base'] = './../';

$pth['folder']['cmsimple'] = $pth['folder']['base'] . 'cmsimple/';

$pth['file']['log'] = $pth['folder']['cmsimple'] . 'log.txt';
$pth['file']['cms'] = $pth['folder']['cmsimple'] . 'cms.php';
$pth['file']['config'] = $pth['folder']['cmsimple'] . 'config.php';

if (file_exists($pth['folder']['cmsimple'].'defaultconfig.php')) {
    include($pth['folder']['cmsimple'].'defaultconfig.php');
}
if (!include($pth['file']['config']))
    die('Config file missing');

//for compatibility XH with older versions
if (!isset($cf['folders']['userfiles']))
    $cf['folders']['userfiles'] = 'userfiles/';
if (!isset($cf['folders']['downloads']))
    $cf['folders']['downloads'] = 'downloads/';
if (!isset($cf['folders']['images']))
    $cf['folders']['images'] = 'images/';
if (!isset($cf['folders']['media']))
    $cf['folders']['media'] = 'downloads/';

//new Userfiles-folder
$pth['folder']['userfiles'] = $pth['folder']['base'] . $cf['folders']['userfiles'];
$pth['folder']['downloads'] = $pth['folder']['base'] . $cf['folders']['downloads'];
$pth['folder']['images'] = $pth['folder']['base'] . $cf['folders']['images'];
$pth['folder']['media'] = $pth['folder']['base'] . $cf['folders']['media'];
$pth['folder']['flags'] = $pth['folder']['images'] . 'flags/';

//HI 2009-10-30 (CMSimple_XH 1.0rc3) debug-mode, enables error-reporting
xh_debugmode();
$errors = array();

$pth['folder']['language'] = $pth['folder']['cmsimple'] . 'languages/';
$pth['folder']['langconfig'] = $pth['folder']['cmsimple'] . 'languages/';
if (preg_match('/\/[A-z]{2}\/[^\/]*/', sv('PHP_SELF')))
    $sl = strtolower(preg_replace('/.*\/([A-z]{2})\/[^\/]*/', '\1', sv('PHP_SELF')));

// for subsite solution - GE 2011-02

$subsite_folder_array = explode('/',str_replace($_SERVER['QUERY_STRING'],'',$_SERVER['REQUEST_URI'])); // creates array
$subsite_folder = array_pop($subsite_folder_array);  // removes last element of array
$subsite_folder = end($subsite_folder_array);  // returns last element of array
if(file_exists('./cmsimplesubsite.htm')){$sl = $subsite_folder;}

// END for subsite solution - GE 2011-02

if (!isset($sl))
    $sl = $cf['language']['default'];
$pth['file']['language'] = $pth['folder']['language'] . basename($sl) . '.php';
$pth['file']['langconfig'] = $pth['folder']['language'] . basename($sl) . 'config.php';
$pth['file']['corestyle'] = $pth['folder']['base'] . 'css/core.css';

if (!file_exists($pth['file']['language'])) {
    copy($pth['folder']['language'].'default.php', $pth['file']['language']);
}
if (!file_exists($pth['file']['langconfig'])) {
    copy($pth['folder']['language'].'defaultconfig.php', $pth['file']['langconfig']);
}

if (!file_exists($pth['file']['language']) && !file_exists($pth['folder']['language'].'default.php')) {
    die('Language file ' . $pth['file']['language'] . ' missing');
}
if (!file_exists($pth['file']['langconfig']) && !file_exists($pth['folder']['language'].'defaultconfig.php')) {
    die('Language config file ' . $pth['file']['langconfig'] . ' missing');
}

include $pth['folder']['language'] . 'default.php';
include $pth['folder']['language'] . 'defaultconfig.php';
include $pth['file']['language'];
include $pth['file']['langconfig'];

$pth['folder']['templates'] = $pth['folder']['base'] . 'templates/';
$pth['folder']['template'] = $pth['folder']['templates'] . $cf['site']['template'] . '/';

// for subsite solution - GE 20011-02

if($txc['subsite']['template']=="")
{
	$pth['folder']['template'] = $pth['folder']['templates'].$cf['site']['template'].'/';
	$pth['file']['template'] = $pth['folder']['template'].'template.htm';
	$pth['file']['stylesheet'] = $pth['folder']['template'].'stylesheet.css';
	$pth['folder']['menubuttons'] = $pth['folder']['template'].'menu/';
	$pth['folder']['templateimages'] = $pth['folder']['template'].'images/';
}
else
{
	$pth['folder']['template'] = $pth['folder']['templates'].$txc['subsite']['template'].'/';
	$pth['file']['template'] = $pth['folder']['template'].'template.htm';
	$pth['file']['stylesheet'] = $pth['folder']['template'].'stylesheet.css';
	$pth['folder']['menubuttons'] = $pth['folder']['template'].'menu/';
	$pth['folder']['templateimages'] = $pth['folder']['template'].'images/';
}

// END for subsite solution - GE 20011-02

$pth['folder']['plugins'] = $pth['folder']['base'] . $cf['plugins']['folder'] . '/';

$iis = strpos(sv('SERVER_SOFTWARE'), "IIS");
$cgi = (php_sapi_name() == 'cgi' || php_sapi_name() == 'cgi-fcgi');

$sn = preg_replace('/([^\?]*)\?.*/', '\1', sv(($iis ? 'SCRIPT_NAME' : 'REQUEST_URI')));
foreach (array('download', 'function', 'media', 'search', 'mailform', 'sitemap', 'text', 'selected', 'login', 'logout', 'settings', 'print', 'retrieve', 'file', 'action', 'validate', 'images', 'downloads', 'edit', 'normal', 'stylesheet', 'passwd', 'userfiles', 'xhpages')as $i)
    initvar($i);

//by GE 2009-10-14 (CMSimple_XH 1.0rc2)
define('CMSIMPLE_ROOT', str_replace('index.php', '', str_replace('/' . $sl . '/', "/", $sn))); //for absolute references
define('CMSIMPLE_BASE', (strtolower($cf['language']['default']) == $sl ? './' : './../')); //for relative references
//END by GE 2009-10-14 (CMSimple_XH 1.0rc2)
// define su - selected url
$su = '';
if (sv('QUERY_STRING') != '') {
    $rq = explode('&', sv('QUERY_STRING'));
    if (!strpos($rq[0], '='))
        $su = $rq[0];
    $v = count($rq);
    for ($i = 0; $i < $v; $i++)
        if (!strpos($rq[$i], '='))
            $GLOBALS[$rq[$i]] = 'true';
}
else
    $su = $selected;
if (!isset($cf['uri']['length']))
    $cf['uri']['length'] = 200;
$su = substr($su, 0, $cf['uri']['length']);

if ($stylesheet != '') {
    header("Content-type: text/css");
    include($pth['file']['stylesheet']);
    exit;
}
if ($download != '')
    download($pth['folder']['downloads'] . basename($download));

$pth['file']['login'] = $pth['folder']['cmsimple'] . 'login.php';
$pth['file']['adm'] = $pth['folder']['cmsimple'] . 'adm.php';

$pth['file']['search'] = $pth['folder']['cmsimple'] . 'search.php';
$pth['file']['mailform'] = $pth['folder']['cmsimple'] . 'mailform.php';

$adm = 0;
$f = '';
if (!@include($pth['file']['login']))
    if ($login)
        e('missing', 'file', $pth['file']['login']);

$cl = 0;
rfc(); // Here content is loaded

if ($function == 'search')
    $f = 'search';
if ($mailform || $function == 'mailform')
    $f = 'mailform';
if ($sitemap)
    $f = 'sitemap';
if ($xhpages)
    $f = 'xhpages';

if ($cf['functions']['file'] != "")
    include($pth['folder']['cmsimple'] . $cf['functions']['file']);

// changes title, keywords and description from $tx to $cf - by MD 2009/08 (CMSimple_XH beta)

foreach ($txc['meta'] as $key => $param) {
    if (strlen(trim($param)) > 0 && $key != 'codepage') {
        $cf['meta'][$key] = $param;
    }
}
foreach ($txc['site'] as $key => $param) {
    if (strlen(trim($param)) > 0) {
        $cf['site'][$key] = $param;
    }
}
foreach ($txc['mailform'] as $key => $param) {
    if (strlen(trim($param)) > 0) {
        $cf['mailform'][$key] = $param;
    }
}
// END of code added for (CMSimple_XH beta)

if (strcasecmp($tx['meta']['codepage'], 'UTF-8') != 0) {
    $e .= '<li>' . sprintf('<b>UTF-8 encoding required, but codepage %s found!</b>', $tx['meta']['codepage']) . tag('br')
	. 'Please change that in Settings&rarr;Language&rarr;Meta&rarr;Codepage'
	. ' and convert all files to UTF-8 without BOM, if not already done.</li>' . "\n";
}

// Plugin loading
if ($function == 'save') {
    $edit = true;
}
if ($cf['plugins']['folder'] != "")
    include($pth['folder']['plugins'] . 'index.php');

if ($f == 'search')
    @include($pth['file']['search']);
if ($f == 'mailform' && $cf['mailform']['email'] != '')
    include($pth['file']['mailform']);
if ($f == 'sitemap') {
    $title = $tx['title'][$f];
    $ta = array();
    $o .= '<h1>' . $title . '</h1>' . "\n";
    for ($i = 0; $i < $cl; $i++)
        if (!hide($i) || $cf['hidden']['pages_sitemap'] == 'true')
            $ta[] = $i;
    $o .= li($ta, 'sitemaplevel');
}

// Compatibility for DHTML menus, moved from functions.php to cms.php - by MD 2009/09 (CMSimple_XH 1.0rc1)
$si = -1;
$hc = array();
for ($i = 0; $i < $cl; $i++) {
    if (!hide($i) || ($i == $s && $cf['hidden']['pages_toc'] == 'true'))
        $hc[] = $i;
    if ($i == $s)
        $si = count($hc);
}
$hl = count($hc);
//END Compatibility for DHTML menus, moved from functions.php to cms.php - by MD 2009/09 (CMSimple_XH 1.0rc1)
// LEGAL NOTICES - no needed under GPL3
if (@$cf['menu']['legal'] == '')
    $cf['menu']['legal'] = 'CMSimple Legal Notices';
if ($su == uenc($cf['menu']['legal'])) {
    $f = $title = $cf['menu']['legal'];
    $s = -1;
    $o .= '<h1>' . $title . '</h1>' . rf($pth['folder']['cmsimple'] . 'legal.txt');
}

if (!include($pth['file']['adm'])) {
    if ($login)
        e('missing', 'file', $pth['file']['adm']);
    if ($s == -1 && !$f && $o == '' && $su == '')
        $s = 0;
}


// CMSimple scripting
if (!($edit && $adm) && $s > -1) {
    $c[$s] = evaluate_cmsimple_scripting($c[$s]);
    if (isset($keywords))
	$cf['meta']['keywords'] = $keywords;
    if (isset($description))
	$cf['meta']['description'] = $description;
}


// CMSimple scripting with error message - MD 2009/10 (CMSimple_XH 1.0rc2)
/*
  if (!($edit && $adm) && $s > -1) {
  $t = preg_replace("/^.*".$cf['scripting']['regexp'].".*$/is", "\\1", $c[$s]);
  if ($t != '' && $t != $c[$s] && $t != 'remove' && $t != 'hide') {
  $output = preg_replace("/".$cf['scripting']['regexp']."/is", "", $c[$s]);
  preg_match('/'.$cf['scripting']['regexp'].'/is', $c[$s], $scripting);
  preg_match_all('/([a-z0-9_]*)\(([^\)]*)[\"|\']*\)/is', $scripting[1], $snippets);
  $evaluate = true;
  foreach($snippets[1] as $function){
  if(!function_exists($function) &&
  !in_array($function, array('if', 'while', 'foreach', 'for', 'declare', 'switch'))
  ){
  $evaluate = false;
  $o .= '<div style="background: #ff3; border: 3px solid #000; padding: 4px 10px; margin: 2px 0;">Error: Call to undefined function '. $function . '().</div>';
  trigger_error('Call to undefined function '. $function . '() from CMSimple-Scripting on page ' . $h[$s], E_USER_WARNING);
  }
  }
  if($evaluate){
  if(is_bool(eval(preg_replace(array("'&(quot|#34);'i", "'&(amp|#38);'i", "'&(apos|#39);'i", "'&(lt|#60);'i", "'&(gt|#62);'i", "'&(nbsp|#160);'i"), array("\"", "&", "'", "<", ">", " "), $t)))){
  trigger_error('Above parse error was evoked by CMSimple scripting  error on page ' . $h[$s], E_USER_WARNING);
  }
  }
  $c[$s] = $output;
  if (isset($keywords))$cf['meta']['keywords'] = $keywords;
  if (isset($description))$cf['meta']['description'] = $description;
  }
  }
 */
//END CMSimple scripting with error message - MD 2009/10 (CMSimple_XH 1.0rc2)


if ($s == -1 && !$f && $o == '')
    shead('404');

if (function_exists('loginforms'))
    loginforms();

foreach (array('content', 'pagedata', 'config', 'language', 'langconfig', 'stylesheet', 'template', 'log') as $i)
    chkfile($i, (($login || $settings) && $adm));
if ($e)
    $o = '<div class="cmsimplecore_warning cmsimplecore_center">' . "\n" . '<b>' . $tx['heading']['warning'] . '</b>' . "\n" . '</div>' . "\n" . '<ul>' . "\n" . $e . '</ul>' . "\n" . $o;
if ($title == '') {
    if ($s > -1)
        $title = $h[$s];
    else if ($f != '')
        $title = ucfirst($f);
}
if ($retrieve) {
    echo '<html><head>' . head() . '</head><body class="retrieve">' . $c[$s] . '</body></html>';
    exit;
}
if ($print) {
    if ($cf['xhtml']['endtags'] == 'true') {
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"',
        ' "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n" .
        '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n";
    } else {
        echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"',
        ' "http://www.w3.org/TR/html4/loose.dtd">' . "\n" . '<html>' . "\n";
    }
    echo '<head>' . "\n" . head(),
    '<meta name="robots" content="noindex">' . "\n" .
    '</head>' . "\n" . '<body class="print"', onload(), '>' . "\n" .
    content(), '</body>' . "\n" . '</html>' . "\n";
    exit;
}





ob_start('final_clean_up');
$debugMode = xh_debugmode();
$plugins = array();
$handle = opendir($pth['folder']['plugins']);


if ($handle) {
    while ($plugin = readdir($handle)) {
        if (strpos($plugin, '.') === false && file_exists($pth['folder']['plugins'] . $plugin . '/admin.php')) {

            $plugins[] = $plugin;
        }
    }
    closedir($handle);
}


if (!include($pth['file']['template'])) {

    echo '<html><head><title>' . $tx['heading']['error'] . '</title></head><body>Template nicht gefunden.(' . $pth['file']['template'] . ')</body></html>';
}

function final_clean_up($html) {
    global $adm, $s, $o, $debugMode, $plugins, $errors, $cf;

    if ($adm === true) {
        $debugHint = '';
        $errorList = '';
        $margin = 34;
        $style = '';

        if ($debugMode) {
            $debugHint .= '<div class="cmsimplecore_debug">' . "\n" . '<b>Notice:</b> Debug-Mode is enabled!' . "\n" . '</div>' . "\n";
            $margin += 25;
        }


        global $errors;
        if(count($errors) > 0){

            $errorList .= '
                <div class="cmsimplecore_warning" style="margin: 0; border-width: 0;">
                  <ul>
                  ';
            $errors =  array_unique($errors);
            foreach($errors as $error){
                $errorList .= '<li>' . $error . '</li>';
            }
            $errorList .= '</ul></div>';
        }
        if (isset($cf['editmenu']['scroll']) && $cf['editmenu']['scroll'] == 'true'){
            $style = ' style="z-index: 99;"';
            $margin = 0;
        }
        else {
             $style =' style="position: fixed; top: 0; left: 0; width: 100%; z-index: 99;"';
	     $html = preg_replace('~</head>~','<style type="text/css">html {margin-top: ' . $margin . 'px;}</style>' ."\n" . '$0', $html, 1);

        }

        $html = preg_replace('~<body[^>]*>~',
                            '$0' . '<div' . $style . '>' . $debugHint. admin_menu($plugins, $debugMode) . '</div>' ."\n" .  $errorList,
                         $html, 1);


    }


    return $html;
}

// GLOBAL INTERNAL FUNCTIONS

function initvar($name) {
    if (!isset($GLOBALS[$name])) {
        if (isset($_GET[$name]))
            $GLOBALS[$name] = $_GET[$name];
        else if (isset($_POST[$name]))
            $GLOBALS[$name] = $_POST[$name];
        else
            $GLOBALS[$name] = @preg_replace("/.*?(" . $name . "=([^\&]*))?.*?/i", "\\2", sv('QUERY_STRING'));
    }
}

function sv($s) {
    if (!isset($_SERVER)) {
        global $_SERVER;
        $_SERVER = $GLOBALS['HTTP_SERVER_VARS'];
    }
    if (isset($_SERVER[$s]))
        return $_SERVER[$s];
    else
        return'';
}

function rmnl($t) {
    return preg_replace("/(\r\n|\r|\n)+/", "\n", $t);
}

function rmanl($t) {
    return preg_replace("/(\r\n|\r|\n)+/", "", $t);
}

function stsl($t) {
    if (get_magic_quotes_gpc())
        return stripslashes($t); else
        return $t;
}

function download($fl) {
    global $sn, $download, $tx;
    if (!is_readable($fl) || ($download != '' && !chkdl($sn . '?download=' . basename($fl)))) {
        global $o, $text_title;
        shead('404');
        $o .= '<p>File ' . $fl . '</p>';
        return;
    } else {
        header('Content-Type: application/save-as');
        header('Content-Disposition: attachment; filename="' . basename($fl) . '"');
        header('Content-Length:' . filesize($fl));
        header('Content-Transfer-Encoding: binary');
        if ($fh = @fopen($fl, "rb")) {
            while (!feof($fh))
                echo fread($fh, filesize($fl));
            fclose($fh);
        }
        exit;
    }
}

function chkdl($fl) {
    global $pth, $sn;
    $m = false;
    if (@is_dir($pth['folder']['downloads'])) {
        $fd = @opendir($pth['folder']['downloads']);
        while (($p = @readdir($fd)) == true) {
            if (preg_match("/.+\..+$/", $p)) {
                if ($fl == $sn . '?download=' . $p)
                    $m = true;
            }
        }
        if ($fd == true)
            closedir($fd);
    }
    return $m;
}

function rf($fl) {
    $fl = @rp($fl);
    if (!file_exists($fl))
        return;
    clearstatcache();
    if (function_exists('file_get_contents'))
        return file_get_contents($fl);
    else {
        return join("\n", file($fl));
    }
}

function chkfile($fl, $writable) {
    global $pth, $tx;
    $t = @rp($pth['file'][$fl]);
    if ($t == '')
        e('undefined', 'file', $fl);
    else if (!file_exists($t))
        e('missing', $fl, $t);
    else if (!is_readable($t))
        e('notreadable', $fl, $t);
    else if (!is_writable($t) && $writable)
        e('notwritable', $fl, $t);
}

function e($et, $ft, $fn) {
    global $e, $tx;
    $e .= '<li><b>' . $tx['error'][$et] . ' ' . $tx['filetype'][$ft] . '</b>' . tag('br') . $fn . '</li>' . "\n";
}

function rfc() {
    global $c, $cl, $h, $u, $l, $su, $s, $pth, $tx, $edit, $adm, $cf;

    $c = array();
    $h = array();
    $u = array();
    $l = array();
    $empty = 0;
    $duplicate = 0;

    $content = file_get_contents($pth['file']['content']);
    $stop = $cf['menu']['levels'];
    $split_token = '#@CMSIMPLE_SPLIT@#';


    $content = preg_split('~</body>~i', $content);
    $content = preg_replace('~<h[1-' . $stop . ']~i', $split_token . '$0', $content[0]);
    $content = explode($split_token, $content);
    array_shift($content);

    foreach ($content as $page) {
        $c[] = $page;
        preg_match('~<h([1-' . $stop . ']).*>(.*)</h~isU', $page, $temp);
        $l[] = $temp[1];
        $temp_h[] = preg_replace('/[ \f\n\r\t\xa0]+/isu', ' ', trim(strip_tags($temp[2])));
    }

    $cl = count($c);
    $s = -1;

    if ($cl == 0) {
        $c[] = '<h1>' . $tx['toc']['newpage'] . '</h1>';
        $h[] = trim(strip_tags($tx['toc']['newpage']));
        $u[] = uenc($h[0]);
        $l[] = 1;
        $s = 0;
        return;
    }

    $ancestors = array();  /* just a helper for the "url" construction:
     * will be filled like this [0] => "Page"
     *                          [1] => "Subpage"
     *                          [2] => "Sub_Subpage" etc.
     */

    foreach ($temp_h as $i => $heading) {
        $temp = trim(strip_tags($heading));
        if ($temp == '') {
            $empty++;
            $temp = $tx['toc']['empty'] . ' ' . $empty;
        }
        $h[] = $temp;
        $ancestors[$l[$i] - 1] = uenc($temp);
        $ancestors = array_slice($ancestors, 0, $l[$i]);
        $url = implode($cf['uri']['seperator'], $ancestors);
        $u[] = substr($url, 0, $cf['uri']['length']);
    }

    foreach ($u as $i => $url) {
        if ($su == $u[$i] || $su == urlencode($u[$i])) {
            $s = $i;
        } // get index of selected page

        for ($j = $i + 1; $j < $cl; $j++) {   //check for duplicate "urls"
            if ($u[$j] == $u[$i]) {
                $duplicate++;
                $h[$j] = $tx['toc']['dupl'] . ' ' . $duplicate;
                $u[$j] = uenc($h[$j]);
            }
        }
    }
    if (!($edit && $adm)) {
        foreach ($c as $i => $j) {
            if (cmscript('remove', $j)) {
                $c[$i] = '#CMSimple hide#';
            }
        }
    }
}

function a($i, $x) {
    global $sn, $u, $cf, $adm;
    if ($i == 0 && !$adm) {
        if ($x == '' && $cf['locator']['show_homepage'] == 'true') {
            return '<a href="' . $sn . '?' . $u[0] . '">';
        }
    }
    return isset($u[$i]) ? '<a href="' . $sn . '?' . $u[$i] . $x . '">' : '<a href="' . $sn . '?' . $x . '">'; // changed by LM CMSimple_XH 1.1
}

function meta($n) {
    global $cf, $print;
    $exclude = array('robots', 'keywords', 'description');
    if ($cf['meta'][$n] != '' && !($print && in_array($n, $exclude)))
        return tag('meta name="' . $n . '" content="' . $cf['meta'][$n] . '"') . "\n";
}

function ml($i) {
    global $f, $sn, $tx;
    $t = '';
    if ($f != $i)
        $t .= '<a href="' . $sn . '?' . amp() . $i . '">';
    $t .= $tx['menu'][$i];
    if ($f != $i)
        $t .= '</a>';
    return $t;
}

function uenc($s) {
    global $tx;
    if (isset($tx['urichar']['org']) && isset($tx['urichar']['new']))
        $s = str_replace(explode(",", $tx['urichar']['org']), explode(",", $tx['urichar']['new']), $s);
    return str_replace('+', '_', urlencode($s));
}

function rp($p) {
    if (@realpath($p) == '')
        return $p;
    else
        return realpath($p);
}

function sortdir($dir) {
    $fs = array();
    $fd = @opendir($dir);
    while (false !== ($fn = @readdir($fd))) {
        $fs[] = $fn;
    }
    if ($fd == true)
        closedir($fd);
    @sort($fs, SORT_STRING);
    return $fs;
}

function cmscript($s, $i) {
    global $cf;
    return preg_match(preg_replace("/\(\.\*\?\)/", $s, "/" . $cf['scripting']['regexp'] . "/is"), $i);
}

function hide($i) {
    global $c, $edit, $adm;
    if ($i < 0) {
        return false;
    }
    return (!($edit && $adm) && cmscript('hide', $c[$i]));
}

// For valid XHTML
function tag($s) {
    global $cf;
    $t = '';
    if ($cf['xhtml']['endtags'] == 'true')
        $t = ' /';
    return '<' . $s . $t . '>';
}

function amp() {
    global $cf;
    if ($cf['xhtml']['amp'] == 'true')
        return '&amp;';
    else
        return('&');
}

function shead($s) {
    global $iis, $cgi, $tx, $txc, $title, $o;
    if ($s == '401')
        header(($cgi || $iis) ? 'status: 401 Unauthorized' : 'HTTP/1.0 401 Unauthorized');
    if ($s == '404') {
	if (function_exists('custom_404')) {
	    custom_404();
	} else {
	    header(($cgi || $iis) ? 'status: 404 Not Found' : 'HTTP/1.0 404 Not Found');
	}
    }
    $title = $tx['error'][$s];
    $o = '<h1>' . $title . '</h1>' . $o;
}

/**
 * Debug-Mode
 * Check if file "_XHdebug.txt" exists to turn on debug-mode
 * with default setting E_ERROR | E_USER_WARNING | E_PARSE.
 * Level of debug mode can be adjusted by placing an
 * integer-value within the file using following values:
 *
 * Possible values of $dbglevel:
 *   0 - Turn off all error reporting
 *   1 - Running errors except warnings
 *   2 - Running errors
 *   3 - Running errors + notices
 *   4 - All errors except notices and warnings
 *   5 - All errors except notices
 *   6 - All errors
 *
 * @author Holger
 * @since CMSimple_XH V.1.0rc3 / Pluginloader V.2.1 beta 9
 *
 * @global array $pth CMSimple's pathes
 * @return boolean Returns true/false if error_reporting was enabled or not
 */
function xh_debugmode() {
    global $pth;
    $dbglevel = '';

    # possible values of $dbglevel:
    # 0 - Turn off all error reporting
    # 1 - Running errors except warnings
    # 2 - Running errors
    # 3 - Running errors + notices
    # 4 - All errors except notices and warnings
    # 5 - All errors except notices
    # 6 - All errors

    if (file_exists($pth['folder']['downloads'] . '_XHdebug.txt')) {
        ini_set('display_errors', 1);
        $dbglevel = rf($pth['folder']['downloads'] . '_XHdebug.txt');
        if (strlen($dbglevel) == 1) {
            set_error_handler('xh_debug');

            switch ($dbglevel) {
                case 0: error_reporting(0);
                    break;
                case 1: error_reporting(E_ERROR | E_USER_WARNING | E_PARSE);
                    break;
                case 2: error_reporting(E_ERROR | E_WARNING | E_USER_WARNING | E_PARSE);
                    break;
                case 3: error_reporting(E_ERROR | E_WARNING | E_USER_WARNING | E_PARSE | E_NOTICE);
                    break;
                case 4: error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_USER_WARNING));
                    break;
                case 5: error_reporting(E_ALL ^ E_NOTICE);
                    break;
                case 6: error_reporting(E_ALL);
                    break;
                default:
                    error_reporting(E_ERROR | E_USER_WARNING | E_PARSE);
            }
        } else {
            error_reporting(E_ERROR | E_USER_WARNING | E_PARSE);
        }
    } else {
        ini_set('display_errors', 0);
        error_reporting(0);
    }
    if (error_reporting() > 0) {
        return true;
    } else {
        return false;
    }
}

function xh_debug($errno, $errstr, $errfile, $errline, $context)
{
    global $errors;

    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
        $errors[] = "<b>XH-ERROR:</b> [$errno] $errstr <br /> $errfile:$errline<br />\n";
        break;

    case E_USER_WARNING:
        echo "<b>XH WARNING:</b>  $errstr <br /> $errfile: $errline<br />\n";
        break;

    case E_USER_NOTICE:
        $errors[] = "<b>XH-NOTICE:</b> [$errno] $errstr <br />$errfile:$errline<br />\n";
        break;

    case E_WARNING:
         $errors[] = "<b>WARNING:</b> $errno $errstr <br />$errfile:$errline<br />\n";
         break;




    case E_NOTICE:
        $errors[] = "<b>NOTICE:</b> $errstr <br />$errfile:$errline<br />\n";
        break;


    case E_ERROR:
         $errors[] = "<b>ERROR:</b> $errstr <br />$errfile:$errline<br />\n";
         break;

    default:
        echo "Unknown error type: [$errno] $errstr<br />$errfile:$errline<br />\n";
        break;
    }

  //  error_log($error, 3, CMS_DIR .'errors.log');
    /* Don't execute PHP internal error handler */

    return true;
}







// PAGE FUNCTIONS
// new function head() ready for html5 - by GE 2009/06 (CMSimple_XH beta)

function head() {
    global $title, $cf, $pth, $tx, $txc, $hjs;
    if (isset($cf['site']['title']) && $cf['site']['title'] != '')
        $t = $cf['site']['title'] . ' - ' . $title; // changed by LM CMSimple_XH 1.1
    else
        $t = $title;
    $t = '<title>' . strip_tags($t) . '</title>' . "\n";
    foreach ($cf['meta'] as $i => $k)
        $t .= meta($i);
    if ($tx['meta']['codepage'] != '')
        $t = tag('meta http-equiv="content-type" content="text/html;charset=' . $tx['meta']['codepage'] . '"') . "\n" . $t;
    return $t . tag('meta name="generator" content="' . CMSIMPLE_XH_VERSION . ' ' . CMSIMPLE_XH_BUILD . ' - www.cmsimple-xh.de"') . "\n" . tag('link rel="stylesheet" href="' . $pth['file']['corestyle'] . '" type="text/css"') . "\n" . tag('link rel="stylesheet" href="' . $pth['file']['stylesheet'] . '" type="text/css"') . "\n" . $hjs;
}

// END new function head() (CMSimple_XH)


function sitename() {
    global $txc;
    return isset($txc['site']['title']) ? $txc['site']['title'] : ''; // changed by GE CMSimple_XH 1.2
}

function pagename() { // changed by GE CMSimple_XH 1.2
    global $cf;
    return isset($cf['site']['title']) ? $cf['site']['title'] : ''; // changed by LM CMSimple_XH 1.1
}

function onload() {
    global $onload;
    return ' onload="' . $onload . '"';
}

function toc($start = NULL, $end = NULL) { // changed by LM CMSimple_XH 1.1
    global $c, $cl, $s, $l, $cf;
    if (isset($start)) {
        if (!isset($end))
            $end = $start;
    }
    else
        $start = 1;
    if (!isset($end))
        $end = $cf['menu']['levels'];
    $ta = array();
    if ($s > -1) {
        $tl = $l[$s];
        for ($i = $s; $i > -1; $i--) {
            if ($l[$i] <= $tl && $l[$i] >= $start && $l[$i] <= $end)
                if (!hide($i) || ($i == $s && $cf['hidden']['pages_toc'] == 'true'))
                    $ta[] = $i;
            if ($l[$i] < $tl)
                $tl = $l[$i];
        }
        @sort($ta);
        $tl = $l[$s];
    }
    else
        $tl = 0;
    $tl += 1 + $cf['menu']['levelcatch'];
    for ($i = $s + 1; $i < $cl; $i++) {
        if ($l[$i] <= $tl && $l[$i] >= $start && $l[$i] <= $end)
            if (!hide($i))
                $ta[] = $i;
        if ($l[$i] < $tl)
            $tl = $l[$i];
    }
    return li($ta, $start);
}

// inserted many "\n" for better structured Sourcecode - by GE 2009/06 (CMSimple_XH beta)

function li($ta, $st) {
    global $s, $l, $h, $cl, $cf, $u;
    $tl = count($ta);
    if ($tl < 1)
        return;
    $t = '';
    if ($st == 'submenu' || $st == 'search')
        $t .= '<ul class="' . $st . '">' . "\n";
    $b = 0;
    if ($st > 0) {
        $b = $st - 1;
        $st = 'menulevel';
    }
    $lf = array();
    for ($i = 0; $i < $tl; $i++) {
        $tf = ($s != $ta[$i]);
        if ($st == 'menulevel' || $st == 'sitemaplevel') {
            for ($k = (isset($ta[$i - 1]) ? $l[$ta[$i - 1]] : $b); $k < $l[$ta[$i]]; $k++)
                $t .= "\n" . '<ul class="' . $st . ($k + 1) . '">' . "\n";
        }
        $t .= '<li class="';
        if (!$tf)
            $t .= 's';
        else if (@$cf['menu']['sdoc'] == "parent" && $s > -1) {
            if ($l[$ta[$i]] < $l[$s]) {
                if (@substr($u[$s], 0, 1 + strlen($u[$ta[$i]])) == $u[$ta[$i]] . $cf['uri']['seperator'])
                    $t .= 's';
            }
        }
        $t .= 'doc';
        for ($j = $ta[$i] + 1; $j < $cl; $j++)
            if (!hide($j) && $l[$j] - $l[$ta[$i]] < 2 + $cf['menu']['levelcatch']) {
                if ($l[$j] > $l[$ta[$i]])
                    $t .= 's';
                break;
            }
        $t .= '">';
        if ($tf)
            $t .= a($ta[$i], '');
        $t .= $h[$ta[$i]];
        if ($tf)
            $t .= '</a>';
        if ($st == 'menulevel' || $st == 'sitemaplevel') {
            if ((isset($ta[$i + 1]) ? $l[$ta[$i + 1]] : $b) > $l[$ta[$i]])
                $lf[$l[$ta[$i]]] = true;
            else {
                $t .= '</li>' . "\n";
                $lf[$l[$ta[$i]]] = false;
            }
            for ($k = $l[$ta[$i]]; $k > (isset($ta[$i + 1]) ? $l[$ta[$i + 1]] : $b); $k--) {
                $t .= '</ul>' . "\n";
                if (isset($lf[$k - 1]))
                    if ($lf[$k - 1]) {
                        $t .= '</li>' . "\n";
                        $lf[$k - 1] = false;
                    }
            };
        }
        else
            $t .= '</li>' . "\n";
    }
    if ($st == 'submenu' || $st == 'search')
        $t .= '</ul>' . "\n";
    return $t;
}

// END modified function li (CMSimple_XH)


function searchbox() {
    global $sn, $tx;
    return '<form action="' . $sn . '" method="post">' . "\n" . '<div id="searchbox">' . "\n" . tag('input type="text" class="text" name="search" size="12"') . "\n" . tag('input type="hidden" name="function" value="search"') . "\n" . ' ' . tag('input type="submit" class="submit" value="' . $tx['search']['button'] . '"') . "\n" . '</div>' . "\n" . '</form>' . "\n";
}

function sitemaplink() {
    return ml('sitemap');
}

function printlink() {
    global $f, $search, $file, $sn, $tx;
    $t = amp() . 'print';
    if ($f == 'search')
        $t .= amp() . 'function=search' . amp() . 'search=' . htmlspecialchars(stsl($search));
    else if ($f == 'file')
        $t .= amp() . 'file=' . $file;
    else if ($f != '' && $f != 'save')
        $t .= amp() . $f;
    else if (sv('QUERY_STRING') != '')
        $t = htmlspecialchars(sv('QUERY_STRING'), ENT_QUOTES, "UTF-8") . $t;
    return '<a href="' . $sn . '?' . $t . '">' . $tx['menu']['print'] . '</a>';
}

// END modified printlink (CMSimple_XH)


function mailformlink() {
    global $txc;
    if ($txc['mailform']['email'] != '')
        return ml('mailform');
}

function guestbooklink() {
    if (function_exists('gblink'))
        return gblink();
}

function loginlink() {
    if (function_exists('lilink'))
        return lilink();
}

function lastupdate($br = NULL, $hour = NULL) { // changed by LM CMSimple_XH 1.1
    global $tx, $pth;
    $t = $tx['lastupdate']['text'] . ':';
    if (!(isset($br)))
        $t .= tag('br');
    else
        $t .= ' ';
    return $t . date($tx['lastupdate']['dateformat'], filemtime($pth['file']['content']) + (isset($hour) ? $hour * 3600 : 0));
}

function legallink() {
    global $cf, $sn; // changed by LM CMSimple_XH 1.1
    return '<a href="' . $sn . '?' . uenc($cf['menu']['legal']) . '">' . $cf['menu']['legal'] . '</a>';
}

function locator() {
    global $title, $h, $s, $f, $c, $l, $tx, $txc, $cf;
    if (hide($s) && $cf['hidden']['path_locator'] != 'true')
        return $h[$s];
    if ($title != '' && (!isset($h[$s]) || $h[$s] != $title))
        return $title;
    $t = '';
    if ($s == 0)
        return $h[$s];
    elseif ($f != '')
        return ucfirst($f);
    elseif ($s > 0) {
        $tl = $l[$s];
        if ($tl > 1) {
            for ($i = $s - 1; $i >= 0; $i--) {
                if ($l[$i] < $tl) {
                    $t = a($i, '') . $h[$i] . '</a> &gt; ' . $t;
                    $tl--;
                }
                if ($tl < 2)
                    break;
            }
        }
        if ($cf['locator']['show_homepage'] == 'true') {
            return a(0, '') . $tx['locator']['home'] . '</a> &gt; ' . $t . $h[$s];
        } else {
            return $t . $h[$s];
        }
    }
    else
        return '&nbsp;';
}

function editmenu() {
    return '';
}

function admin_menu($plugins = array(), $debug = false)
{
	global $adm, $edit, $s, $u, $sn, $tx, $sl, $cf, $su;

	if ($adm)
	{
		$pluginMenu = '';
		if ((bool) $plugins)
		{
			sort($plugins, SORT_STRING);
			$pluginMenu .= '<li><a href="javascript:void(0);">' . ucfirst($tx['editmenu']['plugins']) . "</a>\n    <ul>";
			foreach ($plugins as $plugin)
			{
				if($plugin === 'filebrowser')
				{
				//   continue;
				}
				$pluginMenu .= "\n" .
					'     <li><a href="?' . $plugin . '&amp;normal">' . ucwords($plugin) . '</a></li>';
			}

			$pluginMenu .= "\n    </ul>";
		}


		$t .= "\n" . '<div id="editmenu">';

		$t .= "\n" . '<ul id="edit_menu">' . "\n";

		if ($s < 0)
		{
			$su = $u[0];
		}
		$changeMode = $edit ? 'normal' : 'edit';
		$changeText = $edit ? $tx['editmenu']['normal'] : $tx['editmenu']['edit'];
		$t .= '<li><a href="' . $sn . '?' . $su . '&' . $changeMode . '">' . $changeText . '</a></li>' . "\n";
		$t .= '<li><a href="' . $sn . '?&amp;normal&amp;xhpages" class="">' . ucfirst($tx['editmenu']['pagemanager']) . '</a></li>' . "\n";
		$t .= '<li><a href="javascript:void(0);" class="">' . ucfirst($tx['editmenu']['files']) . '</a>' ."\n";
		$t .= '    <ul>' . "\n";
		$t .= '    <li><a href="' . $sn . '?&amp;normal&amp;images">' . ucfirst($tx['editmenu']['images']) . '</a></li>' . "\n";
		$t .= '    <li><a href="' . $sn . '?&amp;normal&amp;downloads">' . ucfirst($tx['editmenu']['downloads']) . '</a></li>' . "\n";
		$t .= '    <li><a href="' . $sn . '?&amp;normal&amp;media">' . ucfirst($tx['editmenu']['media']) . '</a></li>' . "\n";
		$t .= '    <li><a href="' . $sn . '?&amp;normal&amp;userfiles">' . ucfirst($tx['editmenu']['userfiles']) . '</a></li>' . "\n";
		$t .= '    </ul>' . "\n";
		$t .= '</li>' ."\n";
		$t .= '<li><a href="' . $sn . '?&amp;settings">' . ucfirst($tx['editmenu']['settings']) . '</a>' ."\n"
					. '    <ul>' ."\n";

		if($sl == $cf['language']['default'])
		{
			$t .='    <li><a href="?file=config&amp;action=array">' . ucfirst($tx['editmenu']['configuration']) . '</a></li>' . "\n";
		}

		$t .='    <li><a href="?file=langconfig&amp;action=array">' . ucfirst($tx['editmenu']['langconfig']) . '</a></li>' . "\n"
		. '    <li><a href="?file=language&amp;action=array">' . ucfirst($tx['editmenu']['language']) . '</a></li>' . "\n"
		. '    <li><a href="?file=template&amp;action=edit">' . ucfirst($tx['editmenu']['template']) . '</a></li>' . "\n"
		. '    <li><a href="?file=stylesheet&amp;action=edit">' . ucfirst($tx['editmenu']['stylesheet']) . '</a></li>' . "\n"
		. '    <li><a href="?file=log&amp;action=view" target="_blank">' . ucfirst($tx['editmenu']['log']) . '</a></li>' . "\n"
		. '    <li><a href="' . $sn . '?&amp;validate">' . ucfirst($tx['editmenu']['validate']) . '</a></li>' . "\n"
		. '    <li><a href="' . $sn . '?&amp;sysinfo">' . ucfirst($tx['editmenu']['sysinfo']) . '</a></li>' . "\n"
		. '    </ul>' . "\n"
		. '</li>' . "\n"
		. $pluginMenu . "\n"
		. '</li>' . "\n";
		$t .= '</ul>' . "\n" . '<ul id="editmenu_logout">' . "\n";
		$t .= '<li id="edit_menu_logout"><a href="?&logout">' . ucfirst($tx['editmenu']['logout']) . '</a></li>' . "\n";
		$t .= '</ul>' . "\n";

		return $t . '<div style="float:none;clear:both;padding:0;margin:0;width:100%;height:0px;"></div>' . "\n" . '</div>' . "\n";
	}
}

function content() {
    global $s, $o, $c, $edit, $adm, $cf;
    if (!($edit && $adm) && $s > -1) {
    if (isset($_GET['search'])) {
        $words = explode(',', urldecode($_GET['search']));
        $words = array_map(create_function('$w', 'return "&".$w."(?!([^<]+)?>)&isU";'), $words);
        $c[$s] = preg_replace($words, '<span class="highlight_search">\\0</span>', $c[$s]);
    }
        return $o . preg_replace("/" . $cf['scripting']['regexp'] . "/is", "", $c[$s]);
    }
    else {
        return $o;
    }
}

function submenu() {
    global $s, $cl, $l, $tx, $cf;
    $ta = array();
    if ($s > -1) {
        $tl = $l[$s] + 1 + $cf['menu']['levelcatch'];
        for ($i = $s + 1; $i < $cl; $i++) {
            if ($l[$i] <= $l[$s])
                break;
            if ($l[$i] <= $tl)
                if (!hide($i))
                    $ta[] = $i;
            if ($l[$i] < $tl)
                $tl = $l[$i];
        }
        if (count($ta) != 0)
            return '<h4>' . $tx['submenu']['heading'] . '</h4>' . li($ta, 'submenu');
    }
}

function previouspage() {
    global $s, $cl, $tx;
    for ($i = $s - 1; $i > -1; $i--)
        if (!hide($i))
            return a($i, '') . $tx['navigator']['previous'] . '</a>';
}

function nextpage() {
    global $s, $cl, $tx;
    for ($i = $s + 1; $i < $cl; $i++)
        if (!hide($i))
            return a($i, '') . $tx['navigator']['next'] . '</a>';
}

function top() {
    global $tx;
    return '<a href="#TOP">' . $tx['navigator']['top'] . '</a>';
}

// tagged img-tags in function languagemenu() - by GE 09-06-26 (CMSimple_XH beta3)
// title-tags for flag-gifs - by GE 09-10-07 (CMSimple_XH 1.0rc2)

function languagemenu() {
	global $pth, $cf, $sl;
	if(!file_exists('./cmsimplesubsite.htm')){  // for subsites
		$t = '';
		$r = array();
		$fd = @opendir($pth['folder']['base']);
		while (($p = @readdir($fd)) == true ) {
			if (@is_dir($pth['folder']['base'].$p)) {
				if (preg_match('/^[A-z]{2}$/', $p))$r[] = $p;
			}
		}
		if ($fd == true)closedir($fd); if(count($r) == 0)return ''; if($cf['language']['default'] != $sl)$t .= '<a href="'.$pth['folder']['base'].'">'.tag('img src="'.$pth['folder']['flags'].$cf['language']['default'].'.gif" alt="'.$cf['language']['default'].'" title="&nbsp;'.$cf['language']['default'].'&nbsp;" class="flag"').'</a> '; $v = count($r); for($i = 0;
		$i < $v;
		$i++) {
			if ($sl != $r[$i]) {
				if (is_file($pth['folder']['flags'].'/'.$r[$i].'.gif')) {
					$t .= '<a href="'.$pth['folder']['base'].$r[$i].'/">'.tag('img src="'.$pth['folder']['flags'].$r[$i].'.gif" alt="'.$r[$i].'" title="&nbsp;'.$r[$i].'&nbsp;" class="flag"').'</a> ';
				} else {
					$t .= '<a href="'.$pth['folder']['base'].$r[$i].'/">['.$r[$i].']</a> ';
				}
			}
		}
		return ''.$t.'';
	} // for subsites
}
// END modified function languagemenu() - by GE 09-06-26 (CMSimple_XH beta3)
?>