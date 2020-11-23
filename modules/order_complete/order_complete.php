<?php

woowa_hook_wpajax('save_order_complete');
woowa_hook_wpajax('onoff_order_complete');
woowa_hook_wpajax('order_completed_message');

function woowa_send_order_completed( $order_id, $type = "order_complete" ){
    if (get_option('woowa_license_type') == 'multivendor') {
        woowa_sendapi($order_id, $type);
    }else {
        $main_customer = new MainCustomer();
        $data = $main_customer->get_setting($order_id, $type);
        $main = new Main();
        if ($data['flow'] == true){
            $data = $main->get_data_order($order_id, $type);
            $data = $main->send_message($data);
            if ($data['data_api']['file'] != '') {
                $main->send_image($data);
            }
        }
        $main->writelog($data['log']);
    }
}
add_action('woocommerce_order_status_completed', 'woowa_send_order_completed', 10, 1);

function woowa_send_seller_completed( $order_id, $type = 'order_complete'){
    if (get_option('woowa_license_type') == 'multivendor') {
        woowa_sendapi($order_id, $type);
    }else {
        $main        = new Main();
        $main_seller = new MainSeller();
        $data        = $main_seller->get_setting($order_id, $type);
        
        if ($data['flow'] == true){
            $data = $data['wa_number'];
            foreach ($data as $key => $no_wa) {
                $data  = $main->get_data_order($order_id, 'seller_notification'.$type);
                $no_wa = $main->phone_validation($no_wa, $data['data_api']['country_code']);
                $data['data_api']['no_wa_tujuan'] = $no_wa;

                $data = $main->send_message($data);
                if ($data['data_api']['file'] != '') {
                    $main->send_image($data);
                }

                $main->writelog($data['log']);
            }
        }
    }
}
add_action('woocommerce_order_status_completed', 'woowa_send_seller_completed', 10, 1);

function woowa_order_complete_followup(){
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        $main = new Main();

        $today     = date('Y-m-d');
        $todayhour = date('Y-m-d H:i:s');
        $type      = get_option("woowa_order_completed_followup_type");

        $args = array(
            'status' => 'completed', 
        );
        
        $orders = wc_get_orders( $args );
        
        foreach ($orders as $key => $value) {
            $id       = $value->get_id();
            $followup = get_post_meta($id, 'follow_up', true);
            $sign     = get_post_meta($id, 'follow_up_send', true);
            
            if (!empty($followup) && $sign == 'belum') {
                if ($type == 'day') {
                    if ($followup == $today) {
                        if (get_option('woowa_checkbox_followup') == 'checked' && get_option('woowa_toggle_order_complete') == 'checked') {
                            if (get_option('woowa_license_type') == 'multivendor') {
                                woowa_sendapi($order_id, $type);
                            }else {
                                $data = $main->get_data_order($id, 'order_complete1');
                                $data = $main->send_message($data);
                                if ($data['data_api']['file'] != '') {
                                    $main->send_image($data);
                                }
                                $main->writelog($data['log']);
                            }
                        }
                    }
                }
            }else {
                if ($followup == $todayhour) {
                    if (get_option('woowa_checkbox_followup') == 'checked' && get_option('woowa_toggle_order_complete') == 'checked') {
                        if (get_option('woowa_license_type') == 'multivendor') {
                            woowa_sendapi($order_id, $type);
                        }else {
                            $data = $main->get_data_order($id, 'order_complete1');
                            $data = $main->send_message($data);
                            if ($data['data_api']['file'] != '') {
                                $main->send_image($data);
                            }
                            $main->writelog($data['log']);
                        }
                    }
                }
            }
        }
    }
}

add_action('wp_footer', 'woowa_order_complete_followup', 10, 1);