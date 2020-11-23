<?php

function woowa_save_order_process(){
  $pesan=$_POST['pesan_order_process'];
  $checkbox = $_POST['checkboximage'];
  $gambar = $_POST['image'];
  $toggle = $_POST['onoff_order_process'];

  $pesan = stripslashes($pesan);
  $pesan = str_replace("\'", "'", $pesan);

	if ( get_option('woowa_pesan_order_process') !== false ) {
	    update_option( 'woowa_pesan_order_process', $pesan); 
	} else {
	    $deprecated = null;
	    $autoload = 'no';
	    add_option( 'woowa_pesan_order_process', $pesan, $deprecated, $autoload );
	}

	if ( $checkbox == 'check' ) {
      $checked="checked=checked";
      if ( get_option('woowa_check_order_process') !== false ) {
        update_option('woowa_check_order_process', $checked);
      }else{
        add_option('woowa_check_order_process', $checked);
      }
    }else {
      update_option('woowa_check_order_process', '');
    }

    if ( $gambar!='' ) {
      if( get_option('woowa_image_order_process') !== false ){
        update_option('woowa_image_order_process', $gambar);
      }else {
        add_option('woowa_image_order_process', $gambar);
      }
    }else {
      update_option('woowa_image_order_process', '');
    }

  $fb = '<br>
    <div class="alert alert-success" role="alert" >
    Data Saved.
  </div>';

	echo $fb;
  die();
}

function woowa_onoff_order_process(){
	$toggle = $_POST['data'];

  if ( $toggle == '' ) {
    if( get_option('woowa_toggle_order_process') !== false ){
      update_option('woowa_toggle_order_process', $toggle);
    }else {
      add_option('woowa_toggle_order_process', $toggle);
    }
  }else {
    update_option('woowa_toggle_order_process', 'checked');
  }
  die(get_option('woowa_toggle_order_process'));
}

function woowa_sendapi_order_process( $order_id ) {

  woowa_sendapi( $order_id,'order_process');
  
}

?>