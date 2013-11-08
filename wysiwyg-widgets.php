<?php
/*
Plugin Name: WYSIWYG Widgets
Plugin URI: http://DannyvanKooten.com/wordpress-plugins/wysiwyg-widgets/
Description: Adds a WYSIWYG Widget with a rich text editor and media upload functions.
Version: 2.3.2
Author: Danny van Kooten
Author URI: http://DannyvanKooten.com
Text Domain: wysiwyg-widgets
Domain Path: /languages/
License: GPL v3
*/

/* 
Copyright (C) 2013, Danny van Kooten, hi@dannyvankooten.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define("WYWI_VERSION_NUMBER", "2.3.2");
define("WYWI_PLUGIN_DIR", plugin_dir_path(__FILE__)); 

require_once WYWI_PLUGIN_DIR . 'includes/WYSIWYG_Widgets.php';
require_once WYWI_PLUGIN_DIR . 'includes/WYSIWYG_Widgets_Widget.php';

new WYSIWYG_Widgets();
