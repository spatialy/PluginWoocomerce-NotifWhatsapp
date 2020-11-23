<?php

// add_action('woocommerce_order_status_cancelled', 'woowa_sendapi_seller_notification', 10, 1);

// woowa_hook_wpajax('seller_message');

woowa_hook_wpajax('onoff_seller_list');
woowa_hook_wpajax('delete_seller_notif');
woowa_hook_wpajax('update_seller_notif');
woowa_hook_wpajax('save_new_seller_form');
woowa_hook_wpajax('save_seller_notification');
woowa_hook_wpajax('onoff_seller_notification');
woowa_hook_wpajax('onoff_seller_notification_setting');
