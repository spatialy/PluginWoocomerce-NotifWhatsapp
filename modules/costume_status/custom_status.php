<?php

woowa_hook_wpajax('file_upload');
woowa_hook_wpajax('add_custom_status');
woowa_hook_wpajax('save_custom_status');
woowa_hook_wpajax('onoff_custom_status');
woowa_hook_wpajax('delete_custom_status');
woowa_hook_wpajax('update_custom_status');

add_action('woocommerce_order_status_changed', 'woowa_sendapi_custom_status', 10, 1);