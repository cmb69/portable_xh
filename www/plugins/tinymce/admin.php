<?php

/**
 * @version $Id: admin.php 890 2013-08-26 09:01:05Z manu37 $
 */

if (!$adm) {     return; }

initvar('tinymce');

if ($tinymce) {
    $plugin = basename(dirname(__FILE__), "/");
    $o .= '<div class="plugintext">';
    $o .= '<div class="plugineditcaption">TinyMCE for CMSimple_XH</div>';
    $o .= '<p>Version for CMSimple_XH 1.5.9</p>';
    $o .= '<p>TinyMCE version 3.5.8  &ndash; <a href="http://www.tinymce.com/" target="_blank">http://www.tinymce.com/</a></p>';
    $o .= '<p>CMSimpe_xh & Filebrowser integration';
    $o .= tag('br');
    $o .= 'up to version 1.5.6 &ndash; <a href="http://www.zeichenkombinat.de/" target="_blank">Zeichenkombinat.de</a>';
    $o .= tag('br');
    $o .= 'from &nbsp;version 1.5.7 &ndash; <a href="http://www.pixolution.ch/" target="_blank">pixolution.ch</a></p>';

    $admin= isset($_POST['admin']) ? $_POST['admin'] : $admin = isset($_GET['admin']) ? $_GET['admin'] : '';
    $action= isset($_POST['action']) ? $_POST['action'] : $action = isset($_GET['action']) ? $_GET['action'] : '';
    $o .= plugin_admin_common($action,$admin,$plugin);

    if ($action === 'plugin_save'){  // refresh
        include $pth['folder']['plugins'] . $plugin . '/config/config.php';
    }


    $inits = glob($pth['folder']['plugins'] . 'tinymce/inits/*.js');
    $options = array();

    foreach ($inits as $init) {
        $temp = explode('_', basename($init, '.js'));

        if (isset($temp[1])) {
            $options[] = $temp[1];
        }
    }
    if ((bool) $options) {
        $o .= '<div><form method="post" action="' . $sn . '?&amp;' . $plugin . '">';
         $o .= '<a class="pl_tooltip" href="#" onclick="return false">
             <img class="helpicon" alt="help" src="' . $pth['folder']['plugins'] . 'pluginloader/css/help_icon.png" />
             <span>' . sprintf($plugin_tx[$plugin]['help'], $pth['folder']['plugins'] . $plugin . '/inits') . '</span></a>';
        $o .= 'Toolbar: <select name="' . $pluginloader_cfg['form_namespace'] . 'init">';
        $selected_init = $plugin_cf[$plugin]['init'];
        foreach ($options as $option) {
            $selected = $option == $selected_init ? ' selected="selected"' : '';
            $o .= "<option$selected>$option</option>";
        }


        $o .= '</select>'
                . tag('input type="hidden" name="admin" value="plugin_config"') . "\n"
                . tag('input type="hidden" name="action" value="plugin_save"') . "\n"

                .tag('input type="submit"  name="plugin_submit" value="' . $tx['action']['save'] . '"') . "\n"
                . '</form></div>';
    }
    $o .= '</div>';
}
