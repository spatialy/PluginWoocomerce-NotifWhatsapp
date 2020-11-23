<?php

function woowa_save_seller_notification(){
    $tipe     = $_POST['tipe'];
    $gambar   = $_POST['image'.$tipe];
    $checkbox = $_POST['checkboximage'.$tipe];
    $pesan    = $_POST['pesan_seller_notification'.$tipe];

    $pesan = stripslashes($pesan);
    $pesan = str_replace("\'", "'", $pesan);

    if ( get_option('woowa_pesan_seller_notification'.$tipe) !== false ) {
        update_option( 'woowa_pesan_seller_notification'.$tipe, $pesan); 
    } else {
        $deprecated = null;
        $autoload = 'no';
        add_option( 'woowa_pesan_seller_notification'.$tipe, $pesan, $deprecated, $autoload );
    }

    if ( $checkbox == 'check' ) {
        $checked="checked=checked";
        if ( get_option('woowa_check_image_seller_notification'.$tipe) !== false ) {
            update_option('woowa_check_image_seller_notification'.$tipe, $checked);
        }else{
            add_option('woowa_check_image_seller_notification'.$tipe, $checked);
        }
    }else {
        update_option('woowa_check_image_seller_notification'.$tipe, '');
    }

  //gambar seller
  
    if ( $gambar != '' ) {
        if( get_option('woowa_image_seller_notification'.$tipe) !== false ){
            update_option('woowa_image_seller_notification'.$tipe, $gambar);
        }else {
            add_option('woowa_image_seller_notification'.$tipe, $gambar);
        }
    }else {
        update_option('woowa_image_seller_notification'.$tipe, '');
    }

    $fb = 
    '<br>
        <div class="alert alert-success" role="alert">
        Data Saved.
    </div>';

    echo $fb;
    die();
}

function woowa_onoff_seller_notification(){
    $toggle = $_POST['data'];
    $tipe = $_POST['tipe'];

    if ( $toggle == '' ) {
        if( get_option('woowa_toggle_seller_notification'.$tipe) !== false ){
            update_option('woowa_toggle_seller_notification'.$tipe, $toggle);
        }else {
            add_option('woowa_toggle_seller_notification'.$tipe, $toggle);
        }
    }else {
        update_option('woowa_toggle_seller_notification'.$tipe, 'checked');
    }
}

function woowa_onoff_seller_notification_setting(){
    $toggle = $_POST['data'];
    $tipe = $_POST['tipe'];

    if ( $toggle == '' ) {
        if( get_option('woowa_toggle_seller_notification_setting'.$tipe) !== false ){
            update_option('woowa_toggle_seller_notification_setting'.$tipe, $toggle);
        }else {
            add_option('woowa_toggle_seller_notification_setting'.$tipe, $toggle);
        }
    }else {
        update_option('woowa_toggle_seller_notification_setting'.$tipe, 'checked');
    }
}

function woowa_get_value_from_array_seller($array, $id){
    $result = array();
    foreach ($array as $key => $value) {
        $select = explode(",", $value['select']);
        $phone = explode(",", $value['wa_number']);
        $result['phone_number'] = $phone;
        $result['selected_temp'] = $select;
    }

    return $result;
}

function woowa_get_allstatus_option(){
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
        $getStatuses = wc_get_order_statuses();
    }else {
        $getStatuses = array();
    }

    $view='';
    foreach ($getStatuses as $key => $value) {
        $statuses = str_replace("wc-", "", $key);
        $status_name = str_replace("-", "_", $statuses);
        $check = get_option('woowa_check_'.$status_name);

        $view .= '<option data-id="'.$status_name.'">'.$value.'</option>';
    }

    return $view;
}

function woowa_save_new_seller_form(){
    $name      = $_POST['name'];
    $select    = $_POST['select'];
    $all       = $_POST['alllist'];
    $wa_number = $_POST['wa_number'];

    if ($select) {
        $select = $select;
    }else {
        $all = array();

        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
            $getStatuses = wc_get_order_statuses();
        }else {
            $getStatuses = array();
        }

        foreach ($getStatuses as $key => $value) {
            $statuses = str_replace("wc-", "", $key);
            $status_name = str_replace("-", "_", $statuses);
            $all[] = $status_name;
        }
        array_push($all, 'after_checkout', 'all');
        $select = implode(",", $all);
    }


    if( get_option('woowa_seller_service_data') !== false ){
        $json = get_option('woowa_seller_service_data');
        $array = json_decode($json, 1);
        $end = end($array);
        $id = $end['id']+1;
        $array[$id+1]['id'] = $id;
        $array[$id+1]['name'] = $name;
        $array[$id+1]['select'] = $select;
        $array[$id+1]['wa_number'] = $wa_number;
        $data = json_encode($array);

        update_option('woowa_seller_service_data', $data);
    }else {
        $id = 1;
        $array_data[1]['id'] = $id;
        $array_data[1]['name'] = $name;
        $array_data[1]['select'] = $select;
        $array_data[1]['wa_number'] = $wa_number;
        $data = json_encode($array_data);
        
        add_option('woowa_seller_service_data', $data);
    }
}

function woowa_delete_seller_notif(){
    $id = $_POST['id'];
    delete_option('woowa_toggle_seller_list'.$id);

    if( get_option('woowa_seller_service_data') != false ){
        $json = get_option('woowa_seller_service_data');
        $array = json_decode($json, 1);

        foreach ($array as $key => $value) {
            if ($key==$id) {
                unset($array[$key]);
            }
        }

        $data = json_encode($array);
        update_option('woowa_seller_service_data', $data);
    }
  
    wp_die("success delete");
}

function woowa_onoff_seller_list(){
    $id     = $_POST['id'];
    $toggle = $_POST['data'];

    if ( $toggle == '' ) {
        if( get_option('woowa_toggle_seller_list'.$id) !== false ){
            update_option('woowa_toggle_seller_list'.$id, $toggle);
        }else {
            add_option('woowa_toggle_seller_list'.$id, $toggle);
        }
    }else {
        update_option('woowa_toggle_seller_list'.$id, 'checked');
    }
}

function woowa_update_seller_notif(){
    $id        = $_POST['id'];
    $name      = $_POST['name'];
    $select    = $_POST['select'];
    $all       = $_POST['alllist'];
    $wa_number = $_POST['wa_number'];

    if ($select) {
        $select = $select;
    }else {
        $all = array();

        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
            $getStatuses = wc_get_order_statuses();
        }else {
            $getStatuses = array();
        }

        foreach ($getStatuses as $key => $value) {
            $statuses = str_replace("wc-", "", $key);
            $status_name = str_replace("-", "_", $statuses);
            $all[] = $status_name;
        }

        array_push($all, 'after_checkout', 'all');
        $select = implode(",", $all);
    }

    if( get_option('woowa_seller_service_data') !== false ){
        $json = get_option('woowa_seller_service_data');
        $array = json_decode($json, 1);
        $array[$id]['name']=$name;
        $array[$id]['select']=$select;
        $array[$id]['wa_number']=trim($wa_number);

        $data_json = json_encode($array);
        
        update_option('woowa_seller_service_data', $data_json);
    }

    return $select;
}

