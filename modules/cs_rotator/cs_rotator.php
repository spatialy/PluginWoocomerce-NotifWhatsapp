<?php

// add_action('woocommerce_order_status_cancelled', 'woowa_sendapi_seller_notification', 10, 1);
add_action('admin_notices', 'woowa_reset_array');
woowa_hook_wpajax('get_data_cs');
woowa_hook_wpajax('save_cs_rotator');
woowa_hook_wpajax('onoff_cs_rotator');
woowa_hook_wpajax('onoff_customer_service');
woowa_hook_wpajax('update_customer_service');
woowa_hook_wpajax('delete_customer_service');
woowa_hook_wpajax('save_new_customer_service');