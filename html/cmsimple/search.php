<?php

/**
 * @version $Id: search.php 258 2012-08-17 23:27:29Z cmb69 $
 */

/* utf8-marker = äöü */
/*
  ======================================
  CMSimple_XH 1.5.5
  2012-10-16
  based on CMSimple version 3.3 - December 31. 2009
  For changelog, downloads and information please see http://www.cmsimple-xh.com
  ======================================
  -- COPYRIGHT INFORMATION START --
  Based on CMSimple version 3.3 - December 31. 2009
  Small - simple - smart
  © 1999-2009 Peter Andreas Harteg - peter@harteg.dk

  This file is part of CMSimple_XH
  For licence see notice in /cmsimple/cms.php
  -- COPYRIGHT INFORMATION END --
  ======================================
 */

if (strpos('search.php', strtolower(sv('PHP_SELF')))) {
    die('Access Denied');
}


$title = $tx['title']['search'];
$ta = array();
if ($search != '') {
    $search = utf8_strtolower(trim(stsl($search)));
    $words = explode(' ', $search);

    foreach ($c as $i => $temp) {
        if (!hide($i) || $cf['show_hidden']['pages_search'] == 'true') {
            $found  = true;
	    $temp = evaluate_plugincall($temp, true);
            $temp = utf8_strtolower(strip_tags($temp));
            //$temp = html_entity_decode($temp, ENT_QUOTES, 'utf-8');
            foreach ($words as $word) {
                if (strpos($temp,
			   htmlspecialchars(trim($word), ENT_NOQUOTES, 'UTF-8'))
		    === false)
		{
                    $found = false;
                    break;
                }
            }
            if ($found) {
		$ta[] = $i;
	    }
        }
    }
    
    if(count($ta) > 0){
        $cms_searchresults = "\n" .'<ul>';
	
	$words = (implode( ",", $words));
        foreach($ta as $i){
            $cms_searchresults .= "\n\t" . '<li><a href="' . $sn . '?' . $u[$i] . '&amp;search=' . urlencode($words) .'">' . $h[$i] . '</a></li>';
        }
        $cms_searchresults .= "\n" . '</ul>' . "\n";
    }
}

$o .= '<h1>' . $tx['search']['result'] . '</h1><p>"' . htmlspecialchars($search, ENT_COMPAT, 'UTF-8') . '" ';

if (count($ta) == 0) {
    $o .= $tx['search']['notfound'] . '.</p>';
}
else {
    $o .= $tx['search']['foundin'] . ' ' . count($ta) . ' ';
    if (count($ta) > 1
    )$o .= $tx['search']['pgplural'];
    else
        $o .= $tx['search']['pgsingular'];
    $o .= ':</p>' . $cms_searchresults;
}

?>
