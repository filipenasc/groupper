<?php

/*
Plugin Name: Groupper
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