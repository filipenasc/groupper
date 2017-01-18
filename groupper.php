<?php

/*
Plugin Name: 	Groupper
Description:  Create lists of posts
Version:      0.0.1
Author:       Filipe Nascimento
Author URI:   http://filipenasc.github.io
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Integração RD Station is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
Integração RD Station is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with Integração RD Station. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Load scripts and styles
function groupper_load_scripts($hook) {
	if( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' ) return;
	wp_enqueue_script('jquery');
	wp_enqueue_script('suggest');
	wp_enqueue_script( 'functions-js', plugin_dir_url(__FILE__) . 'admin/assets/js/functions.js' );
}
add_action('admin_enqueue_scripts', 'groupper_load_scripts');

function mytheme_enqueue_options_style() {
    wp_enqueue_style( 'groupper-style', plugin_dir_url(__FILE__) . ' admin/assets/css/style.css' );
}
add_action( 'admin_enqueue_scripts', 'mytheme_enqueue_options_style' );

// Load settings
require_once( dirname(__file__).'/admin/create-settings.php');


?>