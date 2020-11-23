<?php

function woowa_save_custom_status(){
    $custom_status_id = $_POST['custom_status_id'];
    $slug_custom_status = $_POST['slug_custom_status'];
    $pesan = $_POST['pesan_custom_status'.$slug_custom_status];
    $checkbox = $_POST['checkboximage'];
    $gambar = $_POST['image'];
    $toggle = $_POST['onoff_custom_status'];

    $pesan = stripslashes($pesan);
    $pesan = str_replace("\'", "'", $pesan);

	if ( get_option('woowa_pesan_custom_status'.$slug_custom_status) != false ) {
    update_option( 'woowa_pesan_custom_status'.$slug_custom_status, $pesan);
	} else {
    $deprecated = null;
    $autoload = 'no';
    update_option( 'woowa_pesan_custom_status'.$slug_custom_status, $pesan, $deprecated, $autoload );
	}

	if ( $checkbox == 'check' ) {
      $checked="checked=checked";
      if ( get_option('woowa_check_custom_status'.$slug_custom_status) !== false ) {
        update_option('woowa_check_custom_status'.$slug_custom_status, $checked);
      }else{
        add_option('woowa_check_custom_status'.$slug_custom_status, $checked);
      }
    }else {
      update_option('woowa_check_custom_status'.$slug_custom_status, '');
    }

    if ( $gambar!='' ) {
      if( get_option('woowa_image_custom_status'.$slug_custom_status) !== false ){
        update_option('woowa_image_custom_status'.$slug_custom_status, $gambar);
      }else {
        add_option('woowa_image_custom_status'.$slug_custom_status, $gambar);
      }
    }else {
      update_option('woowa_image_custom_status'.$slug_custom_status, '');
    }
// echo $custom_status_id;
  $fb = '<br>
    <div class="alert alert-success" role="alert" >
    Data Saved.
  </div>';

	echo $fb;
  die();
}

function woowa_onoff_custom_status(){
    $toggle = $_POST['data'];
    $custom_status_id = $_POST['custom_status_id'];

    if ( $toggle == '' ) {
        if( get_option('woowa_toggle_custom_status'.$custom_status_id) !== false ){
            update_option('woowa_toggle_custom_status'.$custom_status_id, $toggle);
        }else {
            add_option('woowa_toggle_custom_status'.$custom_status_id, $toggle);
        }
    }else {
        update_option('woowa_toggle_custom_status'.$custom_status_id, 'checked');
    }

    die(get_option('woowa_toggle_custom_status'));
}

function woowa_add_custom_status(){
    $title = $_POST['title'];

    $arrayslug = wc_get_order_statuses();
    foreach ($arrayslug as $key => $value) {
      if ($title == $value) {
        $slug = str_replace('wc-','',$key);
        $slug = str_replace('-','_',$slug);
      }
    }

    if( get_option('woowa_custom_status_data') !== false ){
        $json = get_option('woowa_custom_status_data');
        $array = json_decode($json, 1);
        // $array = array_values($array);
        $end = end($array);
        $id = $end['id']+1;
        $array[$id+1]['id'] = $id;
        $array[$id+1]['slug'] = $slug;
        $array[$id+1]['title'] = $title;
        $data = json_encode($array);
        update_option('woowa_custom_status_data', $data);
    }else {
        $id = 1;
        $array_data[1]['id'] = $id;
        $array[1]['slug'] = $slug;
        $array_data[1]['title'] = $title;
        $data = json_encode($array_data);
        add_option('woowa_custom_status_data', $data);
    }
    $view_accordion = woowa_custom_status_accordion_view($title, $id, $slug);
    die($view_accordion);
}

function woowa_delete_custom_status(){
  $id = $_POST['id'];

  delete_option('woowa_field_no_hp_id_custom_status'.$id);
  delete_option('woowa_status_id_custom_status'.$id);
  delete_option('woowa_pesan_custom_status'.$id);
  delete_option('woowa_check_custom_status'.$id);
  delete_option('woowa_image_custom_status'.$id);
  delete_option('woowa_toggle_custom_status'.$id);

  if( get_option('woowa_custom_status_data') !== false ){
    $json = get_option('woowa_custom_status_data');
    $array = json_decode($json, 1);

    unset($array[$id]);
    $data = json_encode($array);
    update_option('woowa_custom_status_data', $data);
    echo "success delete";
  }
}

function woowa_update_custom_status(){
  $id = $_POST['id'];
  $title = $_POST['title'];

  if( get_option('woowa_custom_status_data') !== false ){
    $json = get_option('woowa_custom_status_data');
    $array = json_decode($json, 1);
    $array[$id]['title']=$title;
    $d = json_encode($array);
    update_option('woowa_custom_status_data', $d);

    die($title);
  }
}

function woowa_sendapi_custom_status($order_id){
  $order = wc_get_order( $order_id );
  $orderstatus = $order->get_status();

  $tipe = str_replace('-','_',$orderstatus);

  $json = get_option('woowa_custom_status_data');
  $array = json_decode($json, 1);
  
  if (!empty($array)) {
    if (!empty($array)) {
      foreach ($array as $key => $value) {
        if ($tipe == $value['slug']) {
          $result = 'custom_status'.$value['slug'];
        }
      }
    }
  }

  woowa_sendapi( $order_id, $result);
}

function woowa_titletoslug($title){
  $title = strtolower($title);
  $slug = str_replace(' ','_',$title);

  return $slug;
}