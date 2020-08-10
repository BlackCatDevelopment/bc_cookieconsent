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

// backend only
$backend = CAT_Backend::getInstance('admintools');
$user    = CAT_Users::getInstance();
$val     = CAT_Helper_Validate::getInstance();

// this will redirect to the login page if the permission is not set
$user->checkPermission('admintools','admintools');

// save settings
if(isset($_REQUEST['save'])) {
    $fields = $values = array();
    foreach($_REQUEST as $key => $value) {
        if(preg_match('~^cc_(.*)~', $key, $m)) {
            $set = $m[1];
            switch($set) {
                case 'type':
                    if(in_array($value,array('info','opt-in','opt-out'))) {
                        $fields[] = $set;
                        $values[] = $value;
                    }
                    break;
                case 'position':
                    if(in_array($value,array('top','bottom','top-left','top-right','bottom-left','bottom-right'))) {
                        $fields[] = $set;
                        $values[] = $value;
                    }
                    break;
                case 'theme':
                    if(in_array($value,array('block','edgeless','classic'))) {
                        $fields[] = $set;
                        $values[] = $value;
                    }
                    break;
                case 'palette':
                    if(in_array($value,array('none','honeybee','purple','mono','red','cosmo','neon'))) {
                        $fields[] = $set;
                        $values[] = $value;
                    }
                    break;
                case 'content_message':
                case 'content_dismiss':
                case 'content_deny':
                case 'content_allow':
                case 'content_learn':
                    $fields[] = str_replace('content_','',$set);
                    $values[] = strip_tags($value);
                    break;
                case 'popup_background':
                case 'popup_text':
                case 'popup_link':
                case 'button_background':
                case 'button_text':
                case 'button_border':
                    if(preg_match('~#[a-f0-9]{6,}~i',$value)) {
                        $fields[] = $set;
                        $values[] = $value;
                    }
                    break;
                case 'href_pageid':
                    $val = intval($value);
                    $pg  = CAT_Helper_Page::getPage($val);
                    if(!empty($pg) && isset($pg['visibility'])) {
                        if(CAT_Helper_Page::isVisible($val)) {
                            $fields[] = 'page_link';
                            $values[] = $val;
                        }
                    }
                    break;
                case 'content_href':
                    $fields[] = 'href';
                    $values[] = ( empty($value) ? '' : CAT_Helper_Validate::sanitize_url($value) );
                    break;
            }
        }
    }
    if(count($fields)>0 && count($values)>0 && count($fields)==count($values)) {
        $sql = 'UPDATE `%smod_cookieconsent_settings` SET ';
        $max = count($fields)-1;
        foreach($fields as $i => $f) {
            $sql .= "`$f`='".$values[$i]."'".( ($i==$max)?'':',' )." ";
        }
        $database->query(sprintf($sql,TABLE_PREFIX));
    }
}

// get current settings
$stmt = $database->query('SELECT * FROM `:prefix:mod_cookieconsent_settings`');
$data = $stmt->fetchRow();

// pages for policy link (visible only)
$pages_list = CAT_Helper_Page::getPages();

// add empty choice
array_unshift($pages_list,array('page_id'=>'999999','level'=>0,'parent'=>0,'menu_title'=>'['.$backend->lang()->translate('please choose').']','is_current'=>true));
$selected = 999999;

// mark current
foreach($pages_list as $i => $p) {
    $pages_list[$i]['is_current'] = false;
    if($p['page_id'] == $data['page_link']) {
        $pages_list[$i]['is_current'] = true;
        $selected = $p['page_id'];
    }
}

$data['select'] = CAT_Helper_ListBuilder::getInstance(true)
       ->config(array('space' => '|-- '))
       ->dropdown("cc_href_pageid", $pages_list, 0, $selected);

$parser->setPath(dirname(__FILE__)."/templates/default");
$parser->output(
    'tool',
    $data
);