<?php
woowa_hook_wpajax('scan_url');
woowa_hook_wpajax('submit_form'); 
woowa_hook_wpajax('save_custom_form');
woowa_hook_wpajax('onoff_custom_form');
woowa_hook_wpajax('delete_custom_form');
woowa_hook_wpajax('update_custom_form');
woowa_hook_wpajax('save_new_title_form');
woowa_hook_wpajax('save_selected_device_customform');

function woowa_custom_form(){
	$view = woowa_main_custom_form_view();
	wp_die($view);
}