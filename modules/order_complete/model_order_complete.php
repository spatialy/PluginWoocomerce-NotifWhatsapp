<?php

function woowa_save_order_complete(){
    $type              = $_POST['types'];
    $gambar            = $_POST['image'];
    $batas_hari        = $_POST['batas_hari'];
    $checkbox          = $_POST['checkboximage'];
    $checkbox_followup = $_POST['toggle_followup'];
    $ke                = $_POST['ke_order_completed'];
    $pesan             = $_POST['pesan_order_complete'];

    ($ke == 0) ? $ke = '' : NULL;

    if ( get_option('woowa_pesan_order_complete'.$ke) == true ) {
        if ($ke == '0') {
            if ( $checkbox == 'checked' ) {
                $checked="checked";
                update_option('woowa_check_order_complete', $checked);
        }else{
            update_option('woowa_check_order_complete', '');
        }

        update_option('woowa_pesan_order_complete', $pesan);
        update_option('woowa_image_order_complete', $gambar);
    }else{
        update_option('woowa_pesan_order_complete'.$ke, $pesan);
        update_option('woowa_image_order_complete'.$ke, $gambar);
        update_option('woowa_check_order_complete'.$ke, $checkbox);  
    }

        update_option("woowa_order_completed_followup", $batas_hari);
        update_option("woowa_order_completed_followup_type", $type);
        ($checkbox_followup == 'on') ? update_option("woowa_checkbox_followup", "checked") : update_option("woowa_checkbox_followup", "");
    } else {
        $deprecated = null;
        $autoload = 'no';

        add_option("woowa_checkbox_followup", "");
        add_option("woowa_order_completed_followup", 2);
        add_option('woowa_pesan_order_complete'.$ke, $pesan);
        add_option('woowa_image_order_complete'.$ke, $gambar);
        add_option('woowa_check_order_complete'.$ke, $checkbox);
        add_option("woowa_order_completed_followup_type", $type);
        add_option('woowa_pesan_order_complete'.$ke, $pesan, $deprecated, $autoload );
    }

    $fb = 
        '<br>
        <div class="alert alert-success" role="alert">
        Data Saved.
        </div>';  
    
    echo $fb;
    die();
}

function woowa_onoff_order_complete(){
    $toggle = $_POST['data'];

    if ( $toggle == '' ) {
        if( get_option('woowa_toggle_order_complete') !== false ){
            update_option('woowa_toggle_order_complete', $toggle);
        }else {
            add_option('woowa_toggle_order_complete', $toggle);
        }
    }else {
        update_option('woowa_toggle_order_complete', 'checked');
    }
}

function woowa_sendapi_order_complete( $order_id) {
    woowa_sendapi( $order_id,'order_complete');
}

function woowa_order_completed_message(){
    if(isset($_POST['data'])){
        $ke = $_POST['data']; 
        if ($ke == 0) {
            // update_option('woowa_order_completed_message_type', $ke);
            $order_completed['pesan'] = get_option('woowa_pesan_order_complete');
            $order_completed['gambar'] = get_option('woowa_image_order_complete');
            $order_completed['checkbox'] = get_option('woowa_check_order_complete');
            die(json_encode($order_completed));
            }else{
            // update_option('woowa_order_completed_message_type', $ke);
            $order_completed['pesan'] = get_option('woowa_pesan_order_complete'.$ke);
            $order_completed['gambar'] = get_option('woowa_image_order_complete'.$ke);
            $order_completed['checkbox'] = get_option('woowa_check_order_complete'.$ke);
            die(json_encode($order_completed));
        } 
    }else{
        // update_option('woowa_order_completed_message_type', $ke);
        $order_completed['pesan'] = get_option('woowa_pesan_order_complete');
        $order_completed['gambar'] = get_option('woowa_image_order_complete');
        $order_completed['checkbox'] = get_option('woowa_check_order_complete');
        return $order_completed['pesan'];
    }
}

function woowa_remove_shop_order_meta_boxe() {
    remove_meta_box( 'postcustom', 'shop_order', 'normal' );
}