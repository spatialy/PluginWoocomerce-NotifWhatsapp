<?php

woowa_hook_wpajax('file_upload');
woowa_hook_wpajax('save_after_checkout');
woowa_hook_wpajax('onoff_after_checkout');

function woowa_save_after_checkout(){
    $afterCheckout = new AfterCheckout();
    $data = $afterCheckout->validation($_POST);
    echo $afterCheckout->save($data);

    die();
}

function woowa_after_checkout_checkbox_page( $checkout ){
    $data = new AfterCheckout();
    $view_checkbox = $data->checkbox_checkoutpage( $checkout );

    return $view_checkbox;
}
add_action('woocommerce_after_checkout_billing_form', 'woowa_after_checkout_checkbox_page');//munculin checkbox send WA di checkout page

function woowa_send_customer_after_checkout($order_id, $type = 'after_checkout'){
    if (get_option('woowa_license_type') == 'multivendor') {
        // woowa_writelog_dev('woowa_send_customer_after_checkout');
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
add_action('woocommerce_checkout_order_processed', 'woowa_send_customer_after_checkout', 10, 1);

function woowa_send_seller_after_checkout($order_id, $type = 'after_checkout'){
    if (get_option('woowa_license_type') == 'multivendor') {
        if (get_option('woowa_toggle_seller_notification_setting') == 'checked') {
            woowa_writelog_dev('woowa_send_seller_after_checkout');
            woowa_sendapi($order_id, $type);
        }
    }else {
        $main_seller = new MainSeller();
        $data = $main_seller->get_setting($order_id, $type = 'after_checkout');
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
add_action('woocommerce_checkout_order_processed', 'woowa_send_seller_after_checkout', 10, 1);

add_filter('is_protected_meta', 'woowa_remove_metadata', 10, 2);
add_action('woocommerce_checkout_update_order_meta', 'woowa_cw_checkout_order_meta');