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

$sql = sprintf(
"CREATE TABLE IF NOT EXISTS `%smod_cookieconsent_settings` (
	`type` VARCHAR(10) NULL DEFAULT NULL COLLATE 'utf8mb4_bin',
	`position` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_bin',
	`theme` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_bin',
	`palette` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_bin',
	`popup_background` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_bin',
	`popup_text` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_bin',
	`popup_link` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_bin',
	`button_background` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_bin',
	`button_text` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_bin',
	`button_border` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_bin',
	`message` TEXT NULL COLLATE 'utf8mb4_bin',
	`allow` TINYTEXT NULL COLLATE 'utf8mb4_bin',
	`deny` TINYTEXT NULL COLLATE 'utf8mb4_bin',
	`dismiss` TINYTEXT NULL COLLATE 'utf8mb4_bin',
	`learn` TINYTEXT NULL COLLATE 'utf8mb4_bin',
	`href` TINYTEXT NULL COLLATE 'utf8mb4_bin',
	`page_link` INT(11) UNSIGNED NULL DEFAULT NULL
) COLLATE='utf8mb4_bin' ENGINE=InnoDB;", TABLE_PREFIX);
$database->query($sql);

$stmt = $database->query('SELECT * FROM `:prefix:mod_cookieconsent_settings`');
if($stmt->rowCount() == 0) { // no settings yet
    $sql = sprintf(
        "INSERT IGNORE INTO `%smod_cookieconsent_settings`
        (`type`, `position`, `theme`, `palette`, `popup_background`, `popup_text`,
        `popup_link`, `button_background`, `button_text`, `button_border`, `message`,
        `allow`, `deny`, `dismiss`, `learn`, `href`, `page_link`)
        VALUES ('opt-out', 'bottom-right', 'edgeless', 'mono', NULL, NULL,
        NULL, NULL, NULL, NULL, '', '', '', '', '', '', NULL);",TABLE_PREFIX);
    $r = $database->query($sql);
}

CAT_Helper_Droplet::installDroplet(__DIR__.'/install/droplet_cookieconsent.zip');