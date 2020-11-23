<?php

// function woowa_my_error_notice() {
// 	$view = '<div class="error notice">
//         <p> '. _e( '<b>Woo WA Plugin :: Please Install and Activated Woocommerce Plugin First!</b>', 'my_plugin_textdomain' ) . '</p>
//     </div>';
// 	return $view;
// }

// if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){

// }else{
// 	add_action( 'admin_notices', 'woowa_my_error_notice' );
// }

function woowa_hook_wpajax($action){
	add_action( 'wp_ajax_'.$action, 'woowa_'.$action );
	add_action( 'wp_ajax_nopriv_'.$action, 'woowa_'.$action );
}


function woowa_activate($from = '') {
	//go live
	$_SESSION['debug']=false;

	//on off toggle multivendor
	add_option('woowa_toggle_wanotif', '');
	add_option('woowa_toggle_apiwha', '');
	add_option('woowa_toggle_waboxapp', '');
	add_option('woowa_toggle_wa_blas', '');
	add_option('woowa_toggle_chat_api', '');
	add_option('woowa_toggle_wassenger', '');
	add_option('woowa_toggle_pesan_enter', '');
	
	// db api dan key pe
	add_option('woowa_ip', '');
	add_option('woowa_api_key', '');
	//aliase init
	add_option('woowa_onhold_alias', 'on-hold');
	add_option('woowa_apk_player_id', '');
	// license type
	add_option('woowa_license_type', '');
	
	//hapus error.log
	$fp = fopen(__DIR__.'/../modules/error/error.log', 'w');
    fwrite($fp, "pelangganNET Plugin is activated.\n");
    fclose($fp);

	//hapus dev.log
	$fp = fopen(__DIR__.'/../modules/error/dev.log', 'w');
    fwrite($fp, "");
    fclose($fp);

    //hapus vendor param
    if ( get_option('woowa_vendor_param') != false ) {
		update_option('woowa_vendor_param','');
	}else{
		add_option('woowa_vendor_param','');
	}

	if ( get_option('SENDINGWHA_URL') != false ) {
		// update_option('SENDINGWHA_URL',SENDINGWHA_URL);
	}else{
		add_option('SENDINGWHA_URL',SENDINGWHA_URL);
	}

	if ( get_option('STATISTIC') != false ) {
		// update_option('STATISTIC','');
	}else{
		add_option('STATISTIC',STATISTIC);
	}

	//integrate
	if (get_option("woowa_license_type") == "multivendor") {
		add_option('woowa_toggle_apiwha', '');
		add_option('woowa_toggle_wanotif', '');
		add_option('woowa_toggle_wa_blas', '');
		add_option('woowa_toggle_chat_api', '');
		add_option('woowa_toggle_waboxapp', '');
		add_option('woowa_toggle_wassenger', '');
	}

    //seller notif after checkout
    if ( get_option('woowa_check_after_checkout') != false ) {
		update_option('woowa_check_after_checkout','checked=checked');
	}else{
		add_option('woowa_check_after_checkout','checked=checked');
	}

    //hapus vendor param
    if ( get_option('woowa_vendor_temp') != false ) {
		update_option('woowa_vendor_temp','');
	}else{
		add_option('woowa_vendor_temp','');
	}

    //hapus vendor param
    if ( get_option('woowa_custom_form_scan_url') != false ) {
		update_option('woowa_custom_form_scan_url','');
	}else{
		add_option('woowa_custom_form_scan_url','');
	}

    //hapus vendor param
    if ( get_option('woowa_custom_form_scan_url_response') != false ) {
		update_option('woowa_custom_form_scan_url_response','');
	}else{
		add_option('woowa_custom_form_scan_url_response','');
	}

	if ($from == 'update') {
		# code...
	}else {
		//hapus license
		if ( get_option('woowa_license') != false ) {
			update_option("woowa_license",'deactive');
		}else{
			add_option('woowa_license','deactive');
		}
		if ( get_option('woowa_license_number') != false ) {
			update_option("woowa_license_number",'');
		}else{
			add_option('woowa_license_number','');
		}
	}

	if ( get_option('woowa_checkbox_wa_text') == false ) {
	    add_option('woowa_checkbox_wa_text','Send me order detail notification through Whatsapp');
	}
	if ( get_option('woowa_checkbox_wa_notif') == false ) {
	    add_option('woowa_checkbox_wa_notif', "");
	}else{
		update_option('woowa_checkbox_wa_notif', "");
	}

	
	$pesan="Hi {billing_first_name}, Terimakasih Telah Berbelanja di {site_url} Pada Tanggal : {order_date_created} .
Berikut detail order anda :
 *Nama Depan* : {billing_first_name}
 *Alamat * : {billing_address_1}
 *Kota* : {billing_city}
 *Kode Pos* : {billing_postcode}
 *Wilayah* : {billing_state}
 *Whatsapp Nomer* : {billing_phone}
 *Produk* : {product_name}
 *Total Belanja* : {total_amount}

Silahkan Selesaikan pembayaran dengan {payment_method_title}

Transfer Uang Ke:
-Bank Nama: BCA
-A/N: PelangganNet
-Nomer Rekening: 987654321

Jika ada pertanyaa silahkan tanyakan di {site_url}
Terimakasih Banyak atas Kunjungan nya.
	";
	if ( get_option('woowa_pesan_after_checkout') == false ) {
	    add_option('woowa_pesan_after_checkout',$pesan);
	}else {
		//update_option('woowa_pesan',$pesan);
	}

$pesan="Hi {billing_first_name}, Terimakasih Telah Berbelanja di {site_url} Pada Tanggal : {order_date_created} .
Berikut detail order anda:
 *Nama Depan* : {billing_first_name}
 *Alamat * : {billing_address_1}
 *Kota* : {billing_city}
 *Kode Pos* : {billing_postcode}
 *Wilayah* : {billing_state}
 *Whatsapp Nomer* : {billing_phone}
 *Produk* : {product_name}
 *Total Belanja* : {total_amount}

Silahkan Selesaikan pembayaran dengan {payment_method_title}

Transfer Uang Ke:
-Bank Nama: BCA
-A/N: PelangganNet
-Nomer Rekening: 987654321

Jika ada pertanyaa silahkan tanyakan di {site_url}
Terimakasih Banyak atas Kunjungan nya.
	";
	if ( get_option('woowa_pesan_custom_status') == false ) {
	    add_option('woowa_pesan_custom_status',$pesan);
	}else {
		//update_option('woowa_pesan',$pesan);
	}
	
	$pesan="Halooo {form_fields[nama]}, this is how Woowa for Caldera form works !

Get all information what you filled before:
name : {form_fields[name]}
phone : {form_fields[no-wa]}
your message : {form_fields[message]}

Awesoommee ! :heart_eyes:";
	if ( get_option('woowa_pesan_custom_form') == false ) {
	    add_option('woowa_pesan_custom_form',$pesan);
	}else {
		//update_option('woowa_pesan',$pesan);
	}

	$pesan="Horeee ! Pesanan Anda Selesai ! 🌟

Hi {billing_first_name}, Terimakasih Telah Berbelanja di {site_url} Pada Tanggal : {order_date_created} .
Berikut detail order anda:
 *Nama Depan* : {billing_first_name}
 *Alamat * : {billing_address_1}
 *Kota* : {billing_city}
 *Kode Pos* : {billing_postcode}
 *Wilayah* : {billing_state}
 *Whatsapp Nomer* : {billing_phone}
 *Produk* : {product_name}
 *Total Belanja* : {total_amount}

Kami harap anda senang berbelanja di kami 😍
Jika ada pertanyaa silahkan tanyakan di {site_url}

Terimakasih Banyak atas Kunjungan nya. ☺🙏🙏	    
	";
	if (get_option('woowa_pesan_order_complete')== false) {
    	add_option( 'woowa_pesan_order_complete', $pesan);
	}else {
		//update_option( 'woowa_pesan_order_complete', $pesan);
	}

	$pesan="This is after sales message!
Don't forget to keep in touch with us! and dont miss our great deal!!

We hope you really enjoy our product 😍
If you have any questions, please contact {site_url}

Thank you so much. ☺🙏🙏	    
	";
	if (get_option('woowa_pesan_order_complete')== false) {
    	add_option( 'woowa_pesan_order_complete1', $pesan);
	}else {
		//update_option( 'woowa_pesan_order_complete', $pesan);
	}
	
	$pesan="Wahhhh!!?? ! Pesanan Kamu Di Batalkan ! 🌟

Hi {billing_first_name}, Mohon Maaf. Pesanan Kamu di {site_url} Pada Tanggal : {order_date_created} .
Berikut detail order anda:
 *Nama Depan* : {billing_first_name}
 *Alamat * : {billing_address_1}
 *Kota* : {billing_city}
 *Kode Pos* : {billing_postcode}
 *Wilayah* : {billing_state}
 *Whatsapp Nomer* : {billing_phone}
 *Produk* : {product_name}
 *Total Belanja* : {total_amount}

Kami Mohon Maaf Pesanan Anda Di Batalkan karena hal hal tertentu 

Terimakasih Banyak Telah Berkunjung. ☺🙏🙏	    
	";
	if (get_option('woowa_pesan_cancel_order')== false) {
    	add_option( 'woowa_pesan_cancel_order', $pesan);
	}

	$pesan="Wuhuuu it is our lucky day!!

Hi Boss!, seseorang baru saja membeli barang di kami {site_url} website! Pada Tanggal : {order_date_created} .

Berikut detail order anda:
 *Nama Depan* : {billing_first_name}
 *Alamat * : {billing_address_1}
 *Kota* : {billing_city}
 *Kode Pos* : {billing_postcode}
 *Wilayah* : {billing_state}
 *Whatsapp Nomer* : {billing_phone}
 *Produk* : {product_name}
 *Total Belanja* : {total_amount}

Ingatkan Mereka Melalui Whatsapp ini : wa.me/62{billing_phone}

Mari kita tetap bekerja keras!!";
		if (get_option('woowa_pesan_seller_notification')== false) {
			add_option( 'woowa_pesan_seller_notification', $pesan);
		}else {
			//update_option( 'woowa_pesan_order_complete', $pesan);
		}

	$pesan="*DEFAULT*
Hi {billing_first_name}, Seperti nya anda lupa dengan pesanan anda yang di pesan melalui {site_url} , Jika Anda lupa, kami ingin mengingatkan Anda tentang pesanan ini yang di pesan tanggal  {order_date_created} .

Berikut detail order anda:
 *ID Pesanan* : {order_id}
 *Nama Depan* : {billing_first_name}
 *Alamat * : {billing_address_1}
 *Kota* : {billing_city}
 *Kode Pos* : {billing_postcode}
 *Wilayah* : {billing_state}
 *Whatsapp Nomer* : {billing_phone}
 *Produk* : {product_name}
 *Total Belanja* : {total_amount}

Silahkan Selesaikan pembayaran dengan {payment_method_title} Setidaknya *24 hours* dari sekarang atau pesanan anda akan kami batalkan.

Transfer Uang Ke:
-Bank Nama: BCA
-A/N: PelangganNet
-Nomer Rekening: 987654321

Jika ada pertanyaa silahkan tanyakan di {site_url}
Terimakasih Banyak atas Kunjungan nya.";
	if (get_option('woowa_pesan_reminder_order')== false) {
    	add_option( 'woowa_pesan_reminder_order', $pesan);
		add_option( 'woowa_pesan_reminder_order_gambar', '');
		add_option('woowa_check_reminder_order', '');
    }else{
		//update_option( 'woowa_pesan_reminder_order', $pesan);
	}

	$pesan="TEMPLATE 1
Maaf mengingatkan Anda lagi {billing_first_name}, Pesanan Kamu Di {site_url} Pada tanggal {order_date_created} belum dibayar,

Berikut detail order anda:
 *ID Pesanan* : {order_id}
 *Nama Depan* : {billing_first_name}
 *Alamat * : {billing_address_1}
 *Kota* : {billing_city}
 *Kode Pos* : {billing_postcode}
 *Wilayah* : {billing_state}
 *Whatsapp Nomer* : {billing_phone}
 *Produk* : {product_name}
 *Total Belanja* : {total_amount}

Silahkan Selesaikan pembayaran dengan {payment_method_title} ,Kita akan mengingatkannya kembali

Transfer Uang Ke:
-Bank Nama: BCA
-A/N: PelangganNet
-Nomer Rekening: 987654321

Jika ada pertanyaa silahkan tanyakan di {site_url}
Terimakasih Banyak atas Kunjungan nya.";
	if (get_option('woowa_pesan_reminder_order1')== false) {
		add_option( 'woowa_pesan_reminder_order1', $pesan);
		add_option( 'woowa_pesan_reminder_order_gambar1', '');
		add_option('woowa_check_reminder_order1', '');
    }else{
		//update_option( 'woowa_pesan_reminder_order', $pesan);
	}

	$pesan="TEMPLATE 2
Hay {billing_first_name}, Stok kami segera habis !

Pesanan kamu pada tanggal {order_date_created} *Belum Dibayar*

Berikut detail order anda:
 *ID Pesanan* : {order_id}
 *Nama Depan* : {billing_first_name}
 *Alamat * : {billing_address_1}
 *Kota* : {billing_city}
 *Kode Pos* : {billing_postcode}
 *Wilayah* : {billing_state}
 *Whatsapp Nomer* : {billing_phone}
 *Produk* : {product_name}
 *Total Belanja* : {total_amount}

Silahkan Selesaikan pembayaran dengan {payment_method_title} ,Kita akan mengingatkannya kembali

Transfer Uang Ke:
-Bank Nama: BCA
-A/N: PelangganNet
-Nomer Rekening: 987654321

Jika ada pertanyaa silahkan tanyakan di {site_url}
Terimakasih Banyak atas Kunjungan nya.";
	if (get_option('woowa_pesan_reminder_order2')== false) {
		add_option( 'woowa_pesan_reminder_order2', $pesan);
		add_option( 'woowa_pesan_reminder_order_gambar2', '');
		add_option('woowa_check_reminder_order2', '');
    }else{
		// update_option( 'woowa_pesan_reminder_order', $pesan);
	}

	$pesan="TEMPLATE 3

Ohh Aku takut kamu kehilangan kesempatan ini  {billing_first_name}, Kode Voucher Kamu Akan Mati 6 Jam Lagi!

Berikut detail order anda:
 *ID Pesanan* : {order_id}
 *Nama Depan* : {billing_first_name}
 *Alamat * : {billing_address_1}
 *Kota* : {billing_city}
 *Kode Pos* : {billing_postcode}
 *Wilayah* : {billing_state}
 *Whatsapp Nomer* : {billing_phone}
 *Produk* : {product_name}
 *Total Belanja* : {total_amount}

Silahkan Selesaikan pembayaran dengan {payment_method_title} ,Kita akan mengingatkannya kembali

Transfer Uang Ke:
-Bank Nama: BCA
-A/N: PelangganNet
-Nomer Rekening: 987654321

Jika ada pertanyaa silahkan tanyakan di {site_url}
Terimakasih Banyak atas Kunjungan nya.

*INI ADALAH KESEMPATAN TERAKHIR ANDA*";
	if (get_option('woowa_pesan_reminder_order3')== false) {
		add_option( 'woowa_pesan_reminder_order3', $pesan);
		add_option( 'woowa_pesan_reminder_order_gambar3', '');		
		add_option('woowa_check_reminder_order3', '');
    }else{
		
	}

	$pesan=" 
Mohon maaf
tapi kami pesanan Anda.
Berikut detail order anda:
 *ID Pesanan* : {order_id}
 *Nama Depan* : {billing_first_name}
 *Alamat * : {billing_address_1}
 *Kota* : {billing_city}
 *Kode Pos* : {billing_postcode}
 *Wilayah* : {billing_state}
 *Whatsapp Nomer* : {billing_phone}
 *Produk* : {product_name}
 *Total Belanja* : {total_amount}

akan dikembalikan! jika Anda memerlukan informasi lebih lanjut, silakan beri tahu kami!
Terima kasih!
	
	";
	if (get_option('woowa_pesan_order_refund')== false) {
		add_option( 'woowa_pesan_order_refund', $pesan);
    }else{
		
	}

	$pesan="
HEY! kami hanya ingin memberitahumu.
Pesananmu pada {site_url} ,di pesan tanggal:
{order_date_created} .
Berikut detail order anda:
 *Nama Depan* : {billing_first_name}
 *Alamat * : {billing_address_1}
 *Kota* : {billing_city}
 *Kode Pos* : {billing_postcode}
 *Wilayah* : {billing_state}
 *Whatsapp Nomer* : {billing_phone}
 *Produk* : {product_name}
 *Total Belanja* : {total_amount}

pesanan Anda sekarang sedang dalam proses !! tunggu dan Anda akan menyukai produk kami !!!
	
	";
	if (get_option('woowa_pesan_order_process')== false) {
		add_option( 'woowa_pesan_order_process', $pesan);
    }else{
		
	}
	
	$pesan=
"Hey! {billing_first_name}
Kami melihat ada yang salah dengan pesanan Anda di {site_url}
dan dengan detailnya sebgai berikut

 *Order Id* : {order_id}
 *Nama Depan* : {billing_first_name}
 *Alamat * : {billing_address_1}
 *Kota* : {billing_city}
 *Kode Pos* : {billing_postcode}
 *Wilayah* : {billing_state}
 *Whatsapp Nomer* : {billing_phone}
 *Produk* : {product_name}
 *Total Belanja* : {total_amount}
gagal diproses, silakan pesan ulang di {site_url}
atau hubungi customer kami!
Terimakasih!";
	if (get_option('woowa_pesan_order_failed')== false) {
		add_option( 'woowa_pesan_order_failed', $pesan);
    }else{
		
	}
	
	$pesan=
"Hey {billing_first_name}
Sepertinya Anda lupa melakukan sesuatu!
apakah Anda ingat membeli beberapa barang bagus di? {site_url}
ini adalah detail pesanan anda!

 *Order Id* : {order_id}
 *Nama Depan* : {billing_first_name}
 *Alamat * : {billing_address_1}
 *Kota* : {billing_city}
 *Kode Pos* : {billing_postcode}
 *Wilayah* : {billing_state}
 *Whatsapp Nomer* : {billing_phone}
 *Produk* : {product_name}
 *Total Belanja* : {total_amount}
  
dan waktu untuk membayar dan Anda akan mendapatkan pesanan Anda sesegera mungkin !!
Terima kasih!";
	if (get_option('woowa_pesan_pending_payment') == false) {
		add_option( 'woowa_pesan_pending_payment', $pesan);
    }
}