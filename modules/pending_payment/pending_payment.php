<?php

woowa_hook_wpajax('file_upload');
woowa_hook_wpajax('save_pending_payment');
woowa_hook_wpajax('onoff_pending_payment');

// add_action('woocommerce_order_status_pending', 'woowa_sendapi_pending_payment', 10, 1);
function woowa_send_customer_pending_payment( $order_id, $type = 'pending_payment'){
    if (get_option('woowa_license_type') == 'multivendor') {
        woowa_sendapi($order_id, $type);
    }else {
        $main_customer = new MainCustomer();
        $data = $main_customer->get_setting($order_id, $type = 'pending_payment');
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
add_action('woocommerce_order_status_pending', 'woowa_send_customer_pending_payment', 10, 1);

function woowa_send_seller_pending_payment( $order_id, $type = 'pending'){
    if (get_option('woowa_license_type') == 'multivendor') {
        woowa_sendapi($order_id, $type);
    }else {
        $main_seller = new MainSeller();
        $data = $main_seller->get_setting($order_id, $type = 'pending');
        $main = new Main();
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
add_action('woocommerce_order_status_pending', 'woowa_send_seller_pending_payment', 10, 1);