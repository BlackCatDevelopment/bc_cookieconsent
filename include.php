<?php

/**
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 3 of the License, or (at
 *   your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *   General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 *   @author          Black Cat Development
 *   @copyright       2020, Black Cat Development
 *   @link            https://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Modules
 *   @package         cookieconsent
 *
 */

if (defined('CAT_PATH')) {
    if (defined('CAT_VERSION')) include(CAT_PATH.'/framework/class.secure.php');
} elseif (file_exists($_SERVER['DOCUMENT_ROOT'].'/framework/class.secure.php')) {
    include($_SERVER['DOCUMENT_ROOT'].'/framework/class.secure.php');
} else {
    $subs = explode('/', dirname($_SERVER['SCRIPT_NAME']));    $dir = $_SERVER['DOCUMENT_ROOT'];
    $inc = false;
    foreach ($subs as $sub) {
        if (empty($sub)) continue; $dir .= '/'.$sub;
        if (file_exists($dir.'/framework/class.secure.php')) {
            include($dir.'/framework/class.secure.php'); $inc = true;    break;
        }
    }
    if (!$inc) trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
}

function cc_include() {
    global $database;

    if(!CAT_Helper_Droplet::is_registered_droplet_css('cookieconsent',PAGE_ID)) {
        CAT_Helper_Droplet::register_droplet_css('cookieconsent', PAGE_ID, 'cookieconsent', 'css/frontend.css');
    }
    if(!CAT_Helper_Droplet::is_registered_droplet_js('cookieconsent',PAGE_ID)) {
        CAT_Helper_Droplet::register_droplet_js('cookieconsent', PAGE_ID, 'cookieconsent', 'js/cookieconsent.min.js');
    }

    // set defaults
    $defaults = array(
        'theme'    => 'classic',
        'type'     => 'info',
        'position' => 'bottom',
        'message'  => 'This website uses cookies to ensure you get the best experience on our website.',
        'deny'     => 'Refuse',
        'dismiss'  => 'Got it!',
        'link'     => 'Learn more',
        'allow'    => 'Allow cookies',
    );

    // get settings
    $stmt = $database->query(
        'SELECT * FROM `:prefix:mod_cookieconsent_settings`'
    );
    $opt = $stmt->fetchRow();

    if(empty($opt)) {
        $opt = array();
    }

    $l = \CAT_Helper_Page::getInstance();

    $l->lang()->addFile(LANGUAGE.'.php',CAT_PATH.'/modules/cookieconsent/languages');
    foreach($defaults as $key => $value) {
        if(empty($opt[$key])) {
            $opt[$key] = $value;
        }
        $opt[$key] = $l->lang()->translate($opt[$key]);
    }

    // link
    if(!empty($opt['page_link'])) {
        $link = CAT_Helper_Page::getLink(intval($opt['page_link']));
    } elseif (!empty($opt['href'])) {
        $link = $opt['href'];
    }

    // colors
    $palette = array();
    if(empty($opt['palette']) || $opt['palette']=='none') {
        foreach(array('popup_background','popup_text','popup_link','button_background','button_text','button_border') as $i => $c) {
            if(!empty($opt[$c])) {
                list($item,$set) = explode('_',$c);
                if(!isset($palette[$item])) {
                    $palette[$item] = array();
                }
                $palette[$item][$set] = $opt[$c];
            }
        }
    }

    $json = null;
    if(!empty($palette)) {
        $json = json_encode($palette,true);
        $json = "\npalette: $json,\n";
    }

    return '
    <script>
    window.cookieconsent.initialise({
      "theme": "'.$opt['theme'].'",
      "position": "'.$opt['position'].'",
      "type": "'.$opt['type'].'",'.$json.'
      "content": {
        "allow": "'.$opt['allow'].'",
        "message": "'.$opt['message'].'",
        "dismiss": "'.$opt['dismiss'].'",
        "deny": "'.$opt['deny'].'",
        "link": "'.$opt['link'].'",
    '.(!empty($link) ? '        "href": "'.$link.'",' : '').'
      }
    });
    $(".cc-window").addClass("cc-palette-'.$opt['palette'].'");
    </script>
    ';
}