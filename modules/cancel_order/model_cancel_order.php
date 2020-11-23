<?php

function woowa_save_cancel_order(){
    $pesan=$_POST['pesan_cancel_order'];
    $checkbox = $_POST['checkboximage'];
    $gambar = $_POST['image'];

    $pesan = stripslashes($pesan);
    $pesan = str_replace("\'", "'", $pesan);

  if ( get_option('woowa_pesan_cancel_order') !== false ) {
      update_option( 'woowa_pesan_cancel_order', $pesan); 
  } else {
      $deprecated = null;
      $autoload = 'no';
      add_option( 'woowa_pesan_cancel_order', $pesan, $deprecated, $autoload );
  }

  if ( $checkbox == 'check' ) {
      $checked="checked=checked";
      if ( get_option('woowa_check_cancel_order') !== false ) {
        update_option('woowa_check_cancel_order', $checked);
      }else{
        add_option('woowa_check_cancel_order', $checked);
      }
  }else {
    update_option('woowa_check_cancel_order', '');
  }

  if ( $gambar!='' ) {
    if( get_option('woowa_image_cancel_order') !== false ){
      update_option('woowa_image_cancel_order', $gambar);
    }else {
      add_option('woowa_image_cancel_order', $gambar);
    }
  }else {
    update_option('woowa_image_cancel_order', '');
  }

  $fb = 
  '<br>
    <div class="alert alert-success" role="alert">
    Data Saved.
  </div>';

  echo $fb;
    die();
}

function woowa_onoff_cancel_order(){
  $toggle = $_POST['data'];

  if ( $toggle == '' ) {
    if( get_option('woowa_toggle_cancel_order') !== false ){
      update_option('woowa_toggle_cancel_order', $toggle);
    }else {
      add_option('woowa_toggle_cancel_order', $toggle);
    }
  }else {
    update_option('woowa_toggle_cancel_order', 'checked');
  }
}

function woowa_sendapi_cancel_order( $order_id) {
  woowa_sendapi( $order_id,'cancel_order');
}