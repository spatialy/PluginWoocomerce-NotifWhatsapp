<?php

if ( ! defined( 'WPINC' ) ) { 
     die('..'); 
}

$timezone=get_option('timezone_string');
if (empty($timezone) or $timezone=='') {
	// $timezone="Asia/Jakarta";
}else{
//	date_default_timezone_set($timezone);
}

$modules=scandir(__DIR__.'/modules');
include_once("config/fn.php");
include_once("vendor/simple_html_dom.php");
$skip=array(".","..","index.html");

include_once("config/def.php");
foreach ($modules as $k => $module) {
	if (in_array($module,$skip)) {continue;}
	if (is_dir(__DIR__.'/modules/'.$module)) {
		$files=scandir(__DIR__.'/modules/'.$module);
		foreach ($files as $k1 => $file) {
			if (in_array($file,$skip)) {continue;}
			if (substr($file,-4,4)!='.php') {continue;}
			if (substr($file,0,5)=='tmpl_') {continue;}
			include_once("modules/".$module."/".$file);
		}
	}
} 

add_action('admin_menu', 'woowa_premium_helper_menu',99 );

function woowa_premium_helper_menu(){ 
	// add_menu_page( 'woocommerce', 'Woo-WA Premium', 'Woo-WA Premium', 'manage_options', 'woo-wa-setting', 'woowa_main' );
	add_menu_page(
		__( 'WhatsappNotification Premium', 'WhatsappNotif Premium' ),
		'WhatsappNotif Premium',
        'manage_options',
        'pelanggan-net-premium',
        'woowa_main',
        plugins_url( 'pelanggan/public/img/wa.png' ),
        54
	);
	add_submenu_page( 'pelanggan-net-premium', 'Woocommerce', 'Woocommerce', 'manage_options', 'pelanggan-net-premium');
	//add_submenu_page( 'pelanggan-net-premium', 'Custom Form', 'Custom Form', 'manage_options', 'pelanggan-net-customform', 'woowa_custom_form');
	add_submenu_page( 'pelanggan-net-premium', 'Settings', 'Settings', 'manage_options', 'pelanggan-net-settings', 'woowa_settings');
}

register_activation_hook( __FILE__, 'woowa_activate' );

$plugin = "woowa/woowa.php";

function woowa_activation_license( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( "admin.php?page=pelanggan-net-settings&tab=license" ) ) );
    }
}
add_action( 'activated_plugin', 'woowa_activation_license' );