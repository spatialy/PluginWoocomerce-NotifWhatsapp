<?php

class AfterCheckout{

	public function validation($p){
		$post['gambar']     = $p['image'];
	    $post['checkbox']   = $p['checkboximage'];
	    $post['pesan']      = $p['pesan_after_checkout'];
	    $post['toggle']     = $p['onoff_after_checkout'];
	    $post['pesan'] = stripslashes($post['pesan']);
		$post['pesan'] = str_replace("\'", "'", $post['pesan']);
		
	    return $post;
	}

	public function save($post){
		extract($post);
		if ( get_option('woowa_pesan_after_checkout') !== false ) {
			update_option( 'woowa_pesan_after_checkout', $pesan);
		} else {
		    $deprecated = null;
		    $autoload = 'no';
		    add_option( 'woowa_pesan_after_checkout', $pesan, $deprecated, $autoload );
		}

		if ( $checkbox == 'check' ) {
	        $checked="checked=checked";
	        if ( get_option('woowa_check_after_checkout') !== false ) {
	            update_option('woowa_check_after_checkout', $checked);
	        }else{
	            add_option('woowa_check_after_checkout', $checked);
	        }
	    }else {
	        update_option('woowa_check_after_checkout', '');
	    }

	    if ( $gambar!='' ) {
	        if( get_option('woowa_image_after_checkout') !== false ){
	            update_option('woowa_image_after_checkout', $gambar);
	        }else {
	            add_option('woowa_image_after_checkout', $gambar);
	        }
	    }else {
	        update_option('woowa_image_after_checkout', '');
	    }

	    $fb = '<br>
	        <div class="alert alert-success" role="alert" >
	        Data Saved.
	    </div>';

		return $fb;
	}

	public function checkbox_checkoutpage( $checkout ) {
		if (get_option('woowa_checkbox_wa_notif')=='checked=checked') {
			echo '<div class="cw_custom_class">';
			$checked = $checkout->get_value( 'custom_checkbox' ) ? $checkout->get_value( 'custom_checkbox' ) : 1;
			woocommerce_form_field( 'custom_checkbox', array(
				'type'          => 'checkbox',
				'label'         => __(get_option('woowa_checkbox_wa_text')),
				'required'      => false,
			), $checked);
			echo '</div>'; 
		}
	}
}