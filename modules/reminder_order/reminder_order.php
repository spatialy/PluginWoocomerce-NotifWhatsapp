<?php

// add_action('admin_notices', 'woowa_sendapi_reminder_order');
add_action('wp_footer', 'woowa_sendapi_reminder_order');

woowa_hook_wpajax('reminder_message');
woowa_hook_wpajax('reminder_accordion');
woowa_hook_wpajax('save_reminder_order');
woowa_hook_wpajax('onoff_reminder_order');