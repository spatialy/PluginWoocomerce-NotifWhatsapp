<?php

function woowa_save_pending_payment(){
  $pesan=$_POST['pesan_pending_payment'];
  $checkbox = $_POST['checkboximage'];
  $gambar = $_POST['image'];
  $toggle = $_POST['onoff_pending_payment'];

  $pesan = stripslashes($pesan);
  $pesan = str_replace("\'", "'", $pesan);

	if ( get_option('woowa_pesan_pending_payment') !== false ) {
	    update_option( 'woowa_pesan_pending_payment', $pesan); 
	} else {
	    $deprecated = null;
	    $autoload = 'no';
	    add_option( 'woowa_pesan_pending_payment', $pesan, $deprecated, $autoload );
	}

	if ( $checkbox == 'check' ) {
      $checked="checked=checked";
      if ( get_option('woowa_check_pending_payment') !== false ) {
        update_option('woowa_check_pending_payment', $checked);
      }else{
        add_option('woowa_check_pending_payment', $checked);
      }
    }else {
      update_option('woowa_check_pending_payment', '');
    }

    if ( $gambar!='' ) {
      if( get_option('woowa_image_pending_payment') !== false ){
        update_option('woowa_image_pending_payment', $gambar);
      }else {
        add_option('woowa_image_pending_payment', $gambar);
      }
    }else {
      update_option('woowa_image_pending_payment', '');
    }

  $fb = '<br>
    <div class="alert alert-success" role="alert" >
    Data Saved.
  </div>';

	echo $fb;
  die();
}

function woowa_onoff_pending_payment(){
	$toggle = $_POST['data'];

  if ( $toggle == '' ) {
    if( get_option('woowa_toggle_pending_payment') !== false ){
      update_option('woowa_toggle_pending_payment', $toggle);
    }else {
      add_option('woowa_toggle_pending_payment', $toggle);
    }
  }else {
    update_option('woowa_toggle_pending_payment', 'checked');
  }
  die(get_option('woowa_toggle_pending_payment'));
}

function woowa_sendapi_pending_payment( $order_id ) {

  woowa_sendapi( $order_id,'pending_payment');
  
}

?>