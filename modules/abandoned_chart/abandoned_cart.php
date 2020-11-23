<?php

// add_action('woocommerce_order_status_cancelled', 'woowa_sendapi_seller_notification', 10, 1);
woowa_hook_wpajax('send_wa_abandoned');
woowa_hook_wpajax('get_cart_contents');
woowa_hook_wpajax('save_abandoned_cart');
woowa_hook_wpajax('save_selected_device');
woowa_hook_wpajax('onoff_abandoned_cart');
woowa_hook_wpajax('update_abandoned_cart');
woowa_hook_wpajax('delete_abandoned_cart');
