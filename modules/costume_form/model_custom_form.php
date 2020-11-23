<?php

function woowa_scan_url() {
  echo $url=$_POST['url'];
  $html='';
  $parse = woowa_file_get_html($url);
        // find all link
  foreach($parse->find('form') as $e) {
    if (isset($e->id)) {
        $form_id=$e->id;
        $html.= '<br><b>Form id</b> : '.$form_id.'<br>';
        foreach($parse->find('form#'.$form_id.' input[type=text]') as $e1) {
          $html.='{'.$e1->name . '}<br>';
        }
        foreach($parse->find('form#'.$form_id.' input[type=number]') as $e2) {
          $html.='{'.$e2->name . '}<br>';
        }
        foreach($parse->find('form#'.$form_id.' input[type=date]') as $e3) {
          $html.='{'.$e3->name . '}<br>';
        }
        foreach($parse->find('form#'.$form_id.' input[type=email]') as $e4) {
          $html.='{'.$e4->name . '}<br>';
        }
        foreach($parse->find('form#'.$form_id.' textarea') as $e5) {
          $html.='{'.$e5->name . '}<br>';
        }
        foreach($parse->find('form#'.$form_id.' input[type=tel]') as $e6) {
          $html.='{'.$e6->name . '}<br>';
        }
        foreach($parse->find('form#'.$form_id.' input[type=radio]') as $e7) {
          $html.='{'.$e7->name . '}<br>';
        }
        foreach($parse->find('form#'.$form_id.' select') as $e8) {
          $html.='{'.$e8->name . '}<br>';
        }
        foreach($parse->find('form#'.$form_id.' input[type=checkbox]') as $e9) {
          $html.='{'.$e9->name . '}<br>';
        }
    }
  }
  add_option('woowa_custom_form_scan_url',$url);
  add_option('woowa_custom_form_scan_url_response',$html);
  wp_die($html);
}

function woowa_footer_script() {
  if( get_option('woowa_custom_form_data') !== false ){
    $json = get_option('woowa_custom_form_data');
    $array = json_decode($json, 1);
    foreach ($array as $k => $v) {
      $id = $k;
      $toggle_custom_form = get_option('woowa_toggle_custom_form'.$id);
      if (!empty(get_option('woowa_toggle_custom_form'.$id))) {
        $form_id=get_option("woowa_form_id_custom_form".$id);
        if ($form_id=='') {
          
        }else{
          echo '
          <script type="text/javascript" src="' . site_url() . '/wp-content/plugins/pelanggan/public/js/serialize.js?v=1"></script>
          <script type="text/javascript">
      
            function r(f){/in/.test(document.readyState)?setTimeout("r("+f+")",9):f()}
            r(function(){
              var element =  document.getElementById("'.$form_id.'");
                if (typeof(element) != "undefined" && element != null)
                {
                  document.querySelector("form#'.$form_id.'").addEventListener("submit", function(e){
                    var data_text=document.querySelectorAll("form#'.$form_id.' input[type=text]");
                    var data_number=document.querySelectorAll("form#'.$form_id.' input[type=number]");
                    var data_date=document.querySelectorAll("form#'.$form_id.' input[type=date]");
                    var data_phone=document.querySelectorAll("form#'.$form_id.' input[type=phone]");
                    var data_email=document.querySelectorAll("form#'.$form_id.' input[type=email]");
                    var data_tel=document.querySelectorAll("form#'.$form_id.' input[type=tel]");
                    var data_radio=document.querySelectorAll("form#'.$form_id.' input[type=radio]");
                    var data_checkbox=document.querySelectorAll("form#'.$form_id.' input[type=checkbox]");
                    var data_select=document.querySelectorAll("form#'.$form_id.' select");
                    var data_textarea=document.querySelectorAll("form#'.$form_id.' textarea");
                    var data="data='.$id.'&action=submit_form&"+serialize(data_text)+"&"+serialize(data_number)+"&"+serialize(data_phone)+"&"+serialize(data_date)+"&"+serialize(data_email)+"&"+serialize(data_textarea)+"&"+serialize(data_tel)+"&"+serialize(data_radio)+"&"+serialize(data_select)+"&"+serialize(data_checkbox);
          
                    var xhttp;
                    xhttp=new XMLHttpRequest();
                    xhttp.onreadystatechange = function(res) {
                      if (this.readyState == 4 && this.status == 200) {
                        console.log("");
                      }
                    };
          
                    var url="'.site_url().'/wp-admin/admin-ajax.php";
                    xhttp.open("POST", url, true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    // console.log(data);
                    xhttp.send(data);
                    return false;
                  });
                }
            });
          </script>';
      
        }      
      }
    }
  }
}

add_action( 'wp_footer', 'woowa_footer_script' );

function woowa_submit_form(){
  $id = $_POST['data'];
  extract($_POST);

  $arrays_form = get_option('woowa_custom_form_data');
  $arrays_form = json_decode($arrays_form, 1);

  $pesan=get_option('woowa_pesan_custom_form'.$id);
  $pesan=str_replace("{", '".$', $pesan);
  $pesan=str_replace("}", '."', $pesan);
  $pesan=str_replace("[", "['", $pesan);
  $pesan=str_replace("]", "']", $pesan);
  $pesan_eval='$isi="'.$pesan.'";';

  $pesan_seller=get_option('woowa_pesan_cf_seller_notification'.$id);
  $pesan_seller=str_replace("{", '".$', $pesan_seller);
  $pesan_seller=str_replace("}", '."', $pesan_seller);
  $pesan_seller=str_replace("[", "['", $pesan_seller);
  $pesan_seller=str_replace("]", "']", $pesan_seller);
  $pesan_seller_eval='$isi_seller="'.$pesan_seller.'";';
  // die('======'.$pesan_eval);  
  $site_url=get_site_url();
  $site_url=str_replace('https://','',$site_url);
  $site_url=str_replace('http://','',$site_url);
  $site_url=str_replace('www.','',$site_url);
  $site_url_arr=explode('/',$site_url);
  if(is_array($site_url_arr)){$site_url=$site_url_arr[0];}
  eval($pesan_eval);
  eval($pesan_seller_eval);

  $id_no_hp=get_option('woowa_field_no_hp_id_custom_form'.$id);
  $id_no_hp=str_replace('{','',$id_no_hp);
  $id_no_hp=str_replace('}','',$id_no_hp);

  if (strpos($id_no_hp,'[')!==false) {
    $key_arr=explode("[",$id_no_hp);
    $no_wa_tujuan=$_POST[$key_arr[0]][substr($key_arr[1],0,-1)];
  }else{
    $no_wa_tujuan=$_POST[$id_no_hp];
  }

  $nom=trim($no_wa_tujuan);
  $prefix=substr($nom, 0,1);

  if ($prefix=='+') {
    $no_wa_tujuan=substr($no_wa_tujuan,1,strlen($no_wa_tujuan));
  }
  $n='';

  if ($prefix=='0') {
    $country_code=json_decode(file_get_contents(__DIR__."/../../phone_country_code.json"),true);
    foreach ($country_code as $k => $v) {
      $kode_negara[$v['code']]=$v['dial_code'];
    }
    
    if(empty($kode_negara[$billing_country])){
        // $kode=62;
        $kode=get_option('woowa_default_country_code');
        if ($kode=="") {
          $n='no tujuan salah '.$no_wa_tujuan;
        }
    }else{
        $kode=$kode_negara[$billing_country];
    }
      //$n="aa ".$kode_negara[$billing_country]."==".$billing_country."||";
    $no_wa_tujuan=$kode.substr($no_wa_tujuan,1,strlen($no_wa_tujuan));
  }
  if( get_option('woowa_image_custom_form'.$id) != '' ){
    $dt['gambar'] =get_option('woowa_image_custom_form'.$id); 		
  }
  echo '='.$no_wa_tujuan.'=';
  echo '='.$isi.'=';
  
  $dt['text'] =$isi; 
  $dt['license']=get_option('woowa_license_number'); 
  $dt['domain'] =$site_url; 
  $dt['tipe']='custom_form';
  $dt['no_wa_tujuan'] =$no_wa_tujuan; 
  $dt['isi_seller'] =$isi_seller;
  $dt['billing_code'] = $kode;
  $dt['player_id'] = get_option('woowa_save_default_device_customform');
  // echo '<pre>'.print_r($dt,1).'</pre>';
  woowa_curl_post($dt,"custom_form");
  woowa_sendapi_seller_notification('custom_form','custom_form', $dt, $id);
  
  wp_die('send');
  
}

function woowa_save_custom_form(){
  $gambar = $_POST['image'];
  $form_id = $_POST['form_id'];
  $pesan = $_POST['pesan_custom_form'];
  $checkbox = $_POST['checkboximage'];
  $custom_form_id = $_POST['custom_form_id'];
  $field_no_hp_id = $_POST['field_no_hp_id'];
  $noseller = $_POST['noseller'.$custom_form_id];
  $pesan_seller = $_POST['pesan_cf_seller_notification'];

  $pesan = stripslashes($pesan);
  $pesan = str_replace("\'", "'", $pesan);

  $pesan_seller = stripslashes($pesan_seller);
  $pesan_seller = str_replace("\'", "'", $pesan_seller);

  if ( get_option('woowa_field_no_hp_id_custom_form'.$custom_form_id) !== false ) {
    update_option( 'woowa_field_no_hp_id_custom_form'.$custom_form_id, $field_no_hp_id); 
  }else {
      $deprecated = null;
      $autoload = 'no';
      add_option( 'woowa_field_no_hp_id_custom_form'.$custom_form_id, $field_no_hp_id, $deprecated, $autoload );
  }

  if ( get_option('woowa_pesan_cf_seller_notification'.$custom_form_id) !== false ) {
    update_option( 'woowa_pesan_cf_seller_notification'.$custom_form_id, $pesan_seller); 
  }else {
    $deprecated = null;
    $autoload = 'no';
    add_option( 'woowa_pesan_cf_seller_notification'.$custom_form_id, $pesan_seller, $deprecated, $autoload );
  }

  if ( $noseller != '' ) {
    if( get_option('woowa_number_cf_seller_notification'.$custom_form_id) !== false ){
      update_option('woowa_number_cf_seller_notification'.$custom_form_id, $noseller);
    }else {
      add_option('woowa_number_cf_seller_notification'.$custom_form_id, $noseller);
    }
  }else {
    update_option('woowa_number_cf_seller_notification'.$custom_form_id, '');
  }

  if ( get_option('woowa_form_id_custom_form'.$custom_form_id) !== false ) {
    update_option( 'woowa_form_id_custom_form'.$custom_form_id, $form_id); 
  } else {
    $deprecated = null;
    $autoload = 'no';
    add_option( 'woowa_form_id_custom_form'.$custom_form_id, $form_id, $deprecated, $autoload );
  }

  if ( get_option('woowa_pesan_custom_form'.$custom_form_id) !== false ) {
    update_option( 'woowa_pesan_custom_form'.$custom_form_id, $pesan); 
  } else {
    $deprecated = null;
    $autoload = 'no';
    add_option( 'woowa_pesan_custom_form'.$custom_form_id, $pesan, $deprecated, $autoload );
  }

  if ( $checkbox == 'check' ) {
    $checked="checked=checked";
    if ( get_option('woowa_check_custom_form'.$custom_form_id) !== false ) {
      update_option('woowa_check_custom_form'.$custom_form_id, $checked);
    }else{
      add_option('woowa_check_custom_form'.$custom_form_id, $checked);
    }
  }else {
    update_option('woowa_check_custom_form'.$custom_form_id, '');
  }

  if ( $gambar!='' ) {
    if( get_option('woowa_image_custom_form'.$custom_form_id) !== false ){
      update_option('woowa_image_custom_form'.$custom_form_id, $gambar);
    }else {
      add_option('woowa_image_custom_form'.$custom_form_id, $gambar);
    }
  }else {
    update_option('woowa_image_custom_form'.$custom_form_id, '');
  }

  $fb = 
  '<br>
    <div class="alert alert-success" role="alert">
    Data Saved.
  </div>';

  echo $fb;
    die();
}

function woowa_onoff_custom_form(){
  $toggle = $_POST['data'];
  $custom_form_id = $_POST['custom_form_id'];

  if ( $toggle == '' ) {
    if( get_option('woowa_toggle_custom_form'.$custom_form_id) !== false ){
      update_option('woowa_toggle_custom_form'.$custom_form_id, $toggle);
    }else {
      add_option('woowa_toggle_custom_form'.$custom_form_id, $toggle);
    }
  }else {
    update_option('woowa_toggle_custom_form'.$custom_form_id, 'checked');
  }
}

function woowa_sendapi_custom_form( $order_id) {
  woowa_sendapi( $order_id,'custom_form');
}

function woowa_save_new_title_form(){
  $title = $_POST['title'];
  
  if( get_option('woowa_custom_form_data') !== false ){
    $json = get_option('woowa_custom_form_data');
    $array = json_decode($json, 1);
    $end = end($array);
    $id = $end['id']+1;
    $array[$id+1]['id'] = $id;
    $array[$id+1]['title'] = $title;
    $data = json_encode($array);
    update_option('woowa_custom_form_data', $data);
  }else {
    $id = 1;
    $array_data[1]['title'] = $title;
    $array_data[1]['id'] = $id;
    $data = json_encode($array_data);
    add_option('woowa_custom_form_data', $data);
  }

  $view_accordion = woowa_custom_form_accordion_view($title, $id);
  die($view_accordion);
}

function woowa_delete_custom_form(){
  $id = $_POST['id'];

  delete_option('woowa_pesan_custom_form'.$id);
  delete_option('woowa_check_custom_form'.$id);
  delete_option('woowa_image_custom_form'.$id);
  delete_option('woowa_toggle_custom_form'.$id);
  delete_option('woowa_form_id_custom_form'.$id);
  delete_option('woowa_field_no_hp_id_custom_form'.$id);
  delete_option('woowa_pesan_cf_seller_notification'.$id);
  
  if( get_option('woowa_custom_form_data') !== false ){
    $json = get_option('woowa_custom_form_data');
    $array = json_decode($json, 1);

    unset($array[$id]);
    $data = json_encode($array);
    update_option('woowa_custom_form_data', $data);
  }

  echo "success delete";
}

function woowa_update_custom_form(){
  $id = $_POST['id'];
  $title = $_POST['title'];

  if( get_option('woowa_custom_form_data') !== false ){
    $json = get_option('woowa_custom_form_data');
    $array = json_decode($json, 1);
    $array[$id]['title']=$title;
    $d = json_encode($array);
    update_option('woowa_custom_form_data', $d);

    die($title);
  }
}

function woowa_save_selected_device_customform(){
  $data = $_POST['data'];

  update_option('woowa_save_default_device_customform', $data);

  $res ='
  <div class="alert alert-success" role="alert" >
      Data Saved.
  </div>';
  
  echo $res;
  die();
}
