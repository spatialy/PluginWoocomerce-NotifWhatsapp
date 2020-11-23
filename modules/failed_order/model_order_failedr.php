<?php

function woowa_save_order_failed(){
  $pesan=$_POST['pesan_order_failed'];
  $checkbox = $_POST['checkboximage'];
  $gambar = $_POST['image'];
  $toggle = $_POST['onoff_order_failed'];

  $pesan = stripslashes($pesan);
  $pesan = str_replace("\'", "'", $pesan);

	if ( get_option('woowa_pesan_order_failed') !== false ) {
	    update_option( 'woowa_pesan_order_failed', $pesan); 
	} else {
	    $deprecated = null;
	    $autoload = 'no';
	    add_option( 'woowa_pesan_order_failed', $pesan, $deprecated, $autoload );
	}

	if ( $checkbox == 'check' ) {
      $checked="checked=checked";
      if ( get_option('woowa_check_order_failed') !== false ) {
        update_option('woowa_check_order_failed', $checked);
      }else{
        add_option('woowa_check_order_failed', $checked);
      }
    }else {
      update_option('woowa_check_order_failed', '');
    }

    if ( $gambar!='' ) {
      if( get_option('woowa_image_order_failed') !== false ){
        update_option('woowa_image_order_failed', $gambar);
      }else {
        add_option('woowa_image_order_failed', $gambar);
      }
    }else {
      update_option('woowa_image_order_failed', '');
    }

  $fb = '<br>
    <div class="alert alert-success" role="alert" >
    Data Saved.
  </div>';

	echo $fb;
  die();
}

function woowa_onoff_order_failed(){
	$toggle = $_POST['data'];

  if ( $toggle == '' ) {
    if( get_option('woowa_toggle_order_failed') !== false ){
      update_option('woowa_toggle_order_failed', $toggle);
    }else {
      add_option('woowa_toggle_order_failed', $toggle);
    }
  }else {
    update_option('woowa_toggle_order_failed', 'checked');
  }
  die(get_option('woowa_toggle_order_failed'));
}

function woowa_sendapi_order_failed( $order_id ) {

  woowa_sendapi( $order_id,'order_failed');
  
}

?>