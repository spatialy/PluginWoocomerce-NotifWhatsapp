<?php

function woowa_save_order_refund(){
  $pesan=$_POST['pesan_order_refund'];
  $checkbox = $_POST['checkboximage'];
  $gambar = $_POST['image'];
  $toggle = $_POST['onoff_order_refund'];

  $pesan = stripslashes($pesan);
  $pesan = str_replace("\'", "'", $pesan);

	if ( get_option('woowa_pesan_order_refund') !== false ) {
	    update_option( 'woowa_pesan_order_refund', $pesan); 
	} else {
	    $deprecated = null;
	    $autoload = 'no';
	    add_option( 'woowa_pesan_order_refund', $pesan, $deprecated, $autoload );
	}

	if ( $checkbox == 'check' ) {
      $checked="checked=checked";
      if ( get_option('woowa_check_order_refund') !== false ) {
        update_option('woowa_check_order_refund', $checked);
      }else{
        add_option('woowa_check_order_refund', $checked);
      }
    }else {
      update_option('woowa_check_order_refund', '');
    }

    if ( $gambar!='' ) {
      if( get_option('woowa_image_order_refund') !== false ){
        update_option('woowa_image_order_refund', $gambar);
      }else {
        add_option('woowa_image_order_refund', $gambar);
      }
    }else {
      update_option('woowa_image_order_refund', '');
    }

  $fb = '<br>
    <div class="alert alert-success" role="alert" >
    Data Saved.
  </div>';

	echo $fb;
  die();
}

function woowa_onoff_order_refund(){
	$toggle = $_POST['data'];

  if ( $toggle == '' ) {
    if( get_option('woowa_toggle_order_refund') !== false ){
      update_option('woowa_toggle_order_refund', $toggle);
    }else {
      add_option('woowa_toggle_order_refund', $toggle);
    }
  }else {
    update_option('woowa_toggle_order_refund', 'checked');
  }
  die(get_option('woowa_toggle_order_refund'));
}

function woowa_sendapi_order_refund( $order_id ) {

  woowa_sendapi( $order_id,'order_refund');
  
}

?>