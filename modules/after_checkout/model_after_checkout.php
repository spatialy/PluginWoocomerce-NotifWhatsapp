<?php

function woowa_cw_checkout_order_meta( $order_id ) {
    if (isset($_POST['custom_checkbox'])){
        update_post_meta( $order_id, 'woowa_checkbox_notification', esc_attr($_POST['custom_checkbox']));
    }
}

function woowa_onoff_after_checkout(){
	$toggle = $_POST['data'];

    if ( $toggle == '' ) {
        if( get_option('woowa_toggle_after_checkout') !== false ){
            update_option('woowa_toggle_after_checkout', $toggle);
        }else {
            add_option('woowa_toggle_after_checkout', $toggle);
        }
    }else {
        update_option('woowa_toggle_after_checkout', 'checked');
    }
    
    die(get_option('woowa_toggle_after_checkout'));
}