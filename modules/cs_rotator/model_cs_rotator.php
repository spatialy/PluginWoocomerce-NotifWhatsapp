<?php

function woowa_get_data_cs(){
    $license = get_option('woowa_license_number');
    $url = GET_DATACS.$license;

    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $r = curl_exec($ch);
    $err = curl_error($ch);
    curl_close ($ch);
    
    $data = json_decode($r);
    
    if ($data->status == 'found') {
        foreach ($data->data as $key => $value) {
            $nama = $value->cs_nama;
            $no_wa = $value->cs_no_wa;
            $player_id = $value->player_id;
            woowa_save_new_customer_service($nama, $no_wa, $player_id);
        }
    }
}

function woowa_save_cs_rotator(){
    $gambar = $_POST['image'];
    $checkbox = $_POST['checkboximage'];
    $pesan = $_POST['pesan_cs_rotator'];

    $pesan = stripslashes($pesan);
    $pesan = str_replace("\'", "'", $pesan);

    if ( get_option('woowa_pesan_cs_rotator') !== false ) {
        update_option( 'woowa_pesan_cs_rotator', $pesan); 
    } else {
        $deprecated = null;
        $autoload = 'no';
        add_option( 'woowa_pesan_cs_rotator', $pesan, $deprecated, $autoload );
    }

    if ( $checkbox == 'check' ) {
        $checked="checked=checked";
        if ( get_option('woowa_check_image_cs_rotator') !== false ) {
            update_option('woowa_check_image_cs_rotator', $checked);
        }else{
            add_option('woowa_check_image_cs_rotator', $checked);
        }
    }else {
        update_option('woowa_check_image_cs_rotator', '');
    }

    //checkbox choice seller
    //gambar seller
    
    if ( $gambar != '' ) {
        if( get_option('woowa_image_cs_rotator') !== false ){
            update_option('woowa_image_cs_rotator', $gambar);
        }else {
            add_option('woowa_image_cs_rotator', $gambar);
        }
    }else {
        update_option('woowa_image_cs_rotator', '');
    }
    
    //nomer seller

    $fb = 
    '<br>
    <div class="alert alert-success" role="alert">
        Data Saved.
    </div>';

    echo $fb;
    die();
}

function woowa_reset_array(){
    $json = get_option('woowa_customer_service_data');
    $array = json_decode($json, 1);
    
    if (!empty($array)) {
        $array = array_values($array);
        array_unshift($array, "phoney");
        unset($array[0]);
    }

    $data = json_encode($array);
    update_option('woowa_customer_service_data', $data);
}

function woowa_onoff_cs_rotator(){
    $toggle = $_POST['data'];

    if ( $toggle == '' ) {
        if( get_option('woowa_toggle_cs_rotator') !== false ){
            update_option('woowa_toggle_cs_rotator', $toggle);
        }else {
            add_option('woowa_toggle_cs_rotator', $toggle);
        }
    }else {
        update_option('woowa_toggle_cs_rotator', 'checked');
    }
}

function woowa_save_new_customer_service($name='', $wa_number='', $player_id=''){
  
    if (!empty($_POST['name'])) {
        $name = $_POST['name'];
        $wa_number = $_POST['wa_number'];
        $player_id = $_POST['player_id'];
    }


    if( !empty(get_option('woowa_customer_service_data'))){
        $json = get_option('woowa_customer_service_data');
        $array = json_decode($json, 1);
        $jml = count($array);
        (!empty($array)) ? $id = $jml+1 : $id = 1;
    
        $array[$jml+1]['id'] = $id;
        $array[$jml+1]['name'] = $name;
        $array[$jml+1]['player_id'] = trim($player_id);
        $array[$jml+1]['wa_number'] = trim($wa_number);

        $data_cs = json_encode($array);
        update_option('woowa_customer_service_data', $data_cs);
    }else {
        $id= 1;
        $array_data[1]['id'] = $id;
        $array_data[1]['name'] = $name;
        $array_data[1]['player_id'] = trim($player_id);
        $array_data[1]['wa_number'] = trim($wa_number);
        $data_cs = json_encode($array_data);
        add_option('woowa_customer_service_data', $data_cs);
    }
}

function woowa_update_customer_service(){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $no_wa = $_POST['wa_number'];
    $player_id = $_POST['player_id'];
    // echo "BLM SMPE IF";

    if( get_option('woowa_customer_service_data') !== false ){
        $json = get_option('woowa_customer_service_data');
        $array = json_decode($json, 1);
        $array[$id]['name']=$name;
        $array[$id]['wa_number']=trim($no_wa);
        $array[$id]['player_id']=trim($player_id);

        $d = json_encode($array);
        
        update_option('woowa_customer_service_data', $d);
    }

    die("sukses!");
  // update_option('woowa_customer_service_data', '{"1":{"id":1,"name":"Usman1","player_id":"1d1ef856-0bd1-4708-b9c9-cb5ef60e96a0","wa_number":"08975835238"},"3":{"id":3,"name":"Dire","player_id":"cfb90daf-74ea-4b48-ac0c-cafff09ef68e","wa_number":"628970680121"},"4":{"id":4,"name":"Lusi","player_id":"d34b0a91-79cf-430f-a680-7d7b2511dcee","wa_number":"089671400654"},"5":{"id":5,"name":"Yudha","player_id":"941b7b8a-d860-4900-8710-9943b706818c","wa_number":"085974568372"}}');
}

function woowa_delete_customer_service(){
    $id = $_POST['id'];
    // echo $id;
    delete_option('woowa_toggle_customer_service'.$id);

    if( get_option('woowa_customer_service_data') != false ){
        $json = get_option('woowa_customer_service_data');
        $array = json_decode($json, 1);

        foreach ($array as $key => $value) {
            if ($key==$id) {
                unset($array[$key]);
            }
        }
        
        // $array = array_values($array);
        // array_unshift($array, "phoney");
        // unset($array[0]);

        $data = json_encode($array);
        update_option('woowa_customer_service_data', $data);
    }

    wp_die("success delete");

}

function woowa_onoff_customer_service(){
    $toggle = $_POST['data'];
    $cs_rotator_id = $_POST['cs_rotator_id'];

    if ( $toggle == '' ) {
        if( get_option('woowa_toggle_customer_service'.$cs_rotator_id) !== false ){
            update_option('woowa_toggle_customer_service'.$cs_rotator_id, $toggle);
        }else {
            add_option('woowa_toggle_customer_service'.$cs_rotator_id, $toggle);
        }
    }else {
        update_option('woowa_toggle_customer_service'.$cs_rotator_id, $toggle);
    }
}