<?php

function woowa_save_abandoned_cart(){
    $gambar   = $_POST['image'];
    $checkbox = $_POST['checkboximage'];
    $pesan    = $_POST['pesan_abandoned_cart'];
    $toggle   = $_POST['onoff_abandoned_cart'];

    $pesan = stripslashes($pesan);
    $pesan = str_replace("\'", "'", $pesan);

    if (get_option('woowa_pesan_abandoned_cart') !== false) {
        update_option('woowa_pesan_abandoned_cart', $pesan);
    } else {
        $deprecated = null;
        $autoload = 'no';
        add_option('woowa_pesan_abandoned_cart', $pesan, $deprecated, $autoload);
    }

    if ($checkbox == 'check') {
        $checked = 'checked=checked';
        if (get_option('woowa_check_abandoned_cart') !== false) {
            update_option('woowa_check_abandoned_cart', $checked);
        } else {
            add_option('woowa_check_abandoned_cart', $checked);
        }
    } else {
        update_option('woowa_check_abandoned_cart', '');
    }

    if ($gambar != '') {
        if (get_option('woowa_image_abandoned_cart') !== false) {
            update_option('woowa_image_abandoned_cart', $gambar);
        } else {
            add_option('woowa_image_abandoned_cart', $gambar);
        }
    } else {
        update_option('woowa_image_abandoned_cart', '');
    }

    $fb = '<br>
    <div class="alert alert-success" role="alert" >
        Data Saved.
    </div>';

    echo $fb;
    die();
}

function woowa_onoff_abandoned_cart(){
    $toggle = $_POST['data'];

    if ($toggle == '') {
        echo 'toogle kosong';
        if (get_option('woowa_toggle_abandoned_cart') !== false) {
            update_option('woowa_toggle_abandoned_cart', $toggle);
        } else {
            add_option('woowa_toggle_abandoned_cart', $toggle);
        }
    } else {
        echo 'toogle masuk';
        update_option('woowa_toggle_abandoned_cart', 'checked');
    }
    echo 'toggle sini';
    die(get_option('woowa_toggle_abandoned_cart'));
}

function woowa_save_selected_device(){
    $data = $_POST['data'];

    update_option('woowa_save_default_device', $data);

    $res ='
    <div class="alert alert-success" role="alert" >
        Data Saved.
    </div>';
    
    echo $res;
    die();
}

function getNameByID($arr, $id){
    foreach($arr as $items){
      if ($items['player_id'] == $id)
        return $items['name'];
    }
  }

function woowa_get_abandoned_cart(){
    global $wpdb;

    $table_prefix = $wpdb->prefix;
    $args = 'SELECT * FROM `'.$table_prefix.'captured_wc_fields`';
    $data = $wpdb->get_results($args, ARRAY_A);

    return $data;
}

function woowa_send_wa_abandoned(){
    $id = $_POST['id'];
    $data = woowa_get_abandoned_cart();

    foreach ($data as $key => $value) {
        if ($id == $value['id']) {
            woowa_form_abandoned_cart($value, 'abandoned_cart');
        }
    }

    die();
}

function woowa_form_abandoned_cart($abandoned_cart, $tipe='abandoned_cart'){
    $other_fields  = unserialize($abandoned_cart['other_fields']);
    $cart_contents = unserialize($abandoned_cart['cart_contents']);

    $order_date_created             = $abandoned_cart['time'];
    $billing_first_name             = $abandoned_cart['name'];
    $billing_email                  = $abandoned_cart['email'];
    $billing_phone                  = $abandoned_cart['phone'];
    $billing_last_name              = $abandoned_cart['surname'];
    $billing_location               = $abandoned_cart['location'];
    $total_amount                   = $abandoned_cart['cart_total'];
    $billing_city                   = $other_fields['wlcfc_shipping_city'];
    $billing_state                  = $other_fields['wlcfc_billing_state'];
    $billing_shipping_city          = $other_fields['wlcfc_shipping_city'];
    $billing_shipping_state         = $other_fields['wlcfc_shipping_state'];
    $billing_order_comments         = $other_fields['wlcfc_order_comments'];
    $billing_company                = $other_fields['wlcfc_billing_company'];
    $billing_postcode               = $other_fields['wlcfc_billing_postcode'];
    $billing_shipping_company       = $other_fields['wlcfc_shipping_company'];
    $billing_shipping_country       = $other_fields['wlcfc_shipping_country'];
    $billing_shipping_postcode      = $other_fields['wlcfc_shipping_postcode'];
    $billing_address_1              = $other_fields['wlcfc_billing_address_1'];
    $billing_address_2              = $other_fields['wlcfc_billing_address_2'];
    $billing_shipping_last_name     = $other_fields['wlcfc_shipping_last_name'];
    $billing_shipping_address_1     = $other_fields['wlcfc_shipping_address_1'];
    $billing_shipping_address_2     = $other_fields['wlcfc_shipping_address_2'];
    $billing_shipping_first_name    = $other_fields['wlcfc_shipping_first_name'];
    $billing_country                = code_to_country($other_fields['wlcfc_shipping_country']);

    $products = Array();
        foreach ($cart_contents as $k => $v) {
            $products[] = $v['product_title'].' - '. $v['quantity'];
            $product_id = $v['product_id'];
            $product_link      = get_permalink($product_id);
            $product_links[]   = get_permalink($product_id);

            $Arrproduct_name[]      = $v['product_title'].' x '.$v['quantity'];
            $Arrproduct_name_link[] = $v['product_title'].' x '.$v['quantity']."\n".$product_link;
        }
        
    if (!empty($Arrproduct_name_link)) {
        $product_name_link = "\n".implode("\n", $Arrproduct_name_link);
    } else {
        $product_name_link = '';
    }
    
    if (!empty($product_links)) {
        $product_link = "\n".implode("\n", $product_links);
    } else {
        $product_link = '';
    }
    
    if (!empty($Arrproduct_name)) {
        $product_name = "\n".implode("\n", $Arrproduct_name);
    } else {
        $product_name = '';
    }

    $product_name =  implode(', ',$products);

    $site_url = get_site_url();
    $site_url = str_replace('https://', '', $site_url);
    $site_url = str_replace('http://', '', $site_url);
    $site_url = str_replace('www.', '', $site_url);
    $site_url_arr = explode('/', $site_url);

    $rp_pesan = get_option('woowa_pesan_abandoned_cart');
    $rp_Pesan = str_replace('{', '$', $rp_pesan);
    $rp_Pesan = str_replace('}', '', $rp_Pesan);
    $pesan_eval = '$isi="'.$rp_Pesan.'";';
    eval($pesan_eval);

    $no_wa_tujuan = woowa_validasi_nomor($billing_phone, $billing_shipping_country);
    $data_api['text'] = $isi;
    $data_api['license'] = get_option('woowa_license_number');

    if (is_array($site_url_arr)) {
        $site_url = $site_url_arr[0];
    }

    $data_api['domain'] = $site_url;
    $data_api['tipe'] = $tipe;
    $data_api['no_wa_tujuan'] = $no_wa_tujuan;

    if (!empty(get_option("woowa_check_$tipe"))) {
        if (!empty(get_option("woowa_image_$tipe"))) {
            $data_api['file'] = get_option("woowa_image_$tipe");
        }
    } else {
        $data_api['file'] = '';
    }

    $bdata = array(
        'kota' => $billing_city,
        'produk' => $product_name,
        'nama_pembeli' => "$billing_first_name $billing_last_name",
        'email' => $billing_email,
        'no_hp' => $billing_phone,
        'lokasi' => $billing_location,
    );

    $data_api['player_id'] = get_option('woowa_save_default_device');
    $data_api['bdata'] = json_encode($bdata);

    if (get_option('woowa_toggle_abandoned_cart') == 'checked') {
        woowa_curl_post($data_api, 'abandoned_cart');
    }
}