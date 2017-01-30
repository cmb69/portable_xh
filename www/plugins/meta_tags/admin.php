<?php

/**
 * Meta-Tags - module admin
 *
 * Admin-interface for configuring the plugin
 * via the standard-functions of pluginloader.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Metatags
 * @author    Martin Damken <kontakt@zeichenkombinat.de>
 * @author    The CMSimple_XH developers <devs@cmsimple-xh.org>
 * @copyright 2009-2015 The CMSimple_XH developers <http://cmsimple-xh.org/?The_Team>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @version   SVN: $Id: admin.php 1597 2015-05-05 14:12:27Z cmb69 $
 * @link      http://cmsimple-xh.org/
 */

/*
 * Check if PLUGINLOADER is calling and die if not.
 */
if (!defined('PLUGINLOADER')) {
    die(
        'Plugin '. basename(dirname(__FILE__))
        . ' requires a newer version of the Pluginloader. No direct access.'
    );
}

/*
 * Check if plugin was called.
 * If so, let the Loader create and handle the admin-menu.
 */
if (XH_wantsPluginAdministration('meta_tags')) {
    $o .= print_plugin_admin('off');
    if ($admin == '') {
        $o .= "\n" . '<div class="plugintext"><div class="plugineditcaption">'
            . ucfirst(str_replace('_', ' ', $plugin)) . '</div></div>' . '<br>';
    }
    $o .= plugin_admin_common($action, $admin, $plugin);
}

?>
