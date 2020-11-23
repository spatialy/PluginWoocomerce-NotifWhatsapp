<?php

function woowa_save_reminder_order(){
    $ke = $_POST['ke'];
    $type = $_POST['types'];
    $gambar = $_POST['image'];
    $batas_hari = $_POST['batas_hari'];
    $pesan = $_POST['pesan_reminder_order'];
    $reminder_time = $_POST['reminder_time'];

    $pesan = stripslashes($pesan);
    $pesan = str_replace("\'", "'", $pesan);
    
    ($ke == '0') ? $ke='' : $ke = $ke;
    (isset($_POST['checkboximage'])) ? $checkbox = $_POST['checkboximage'] : $checkbox = '';
    (isset($_POST['reminder_loop'])) ? $reminder_loop = $_POST['reminder_loop'] : $reminder_loop ='';
    (isset($_POST['diff_templates'])) ? $reminder_diff_templates = $_POST['diff_templates'] : $reminder_diff_templates = '';
    
    if ( get_option('woowa_pesan_reminder_order') !== false ) {
        if ($ke == '0') {
            update_option('woowa_pesan_reminder_order', $pesan);
            update_option('woowa_pesan_reminder_order_gambar', $gambar);
        if ( $checkbox == 'checked' ) {
            $checked="checked";
            update_option('woowa_check_reminder_order', $checked);
        }else{
            update_option('woowa_check_reminder_order', '');
        }
        }else{
            update_option('woowa_pesan_reminder_order'.$ke, $pesan);
            update_option('woowa_pesan_reminder_order_gambar'.$ke, $gambar);
            update_option('woowa_check_reminder_order'.$ke, $checkbox);  
        }

        update_option('on_hold_reminder',$batas_hari);
        update_option('woowa_on_hold_reminder_type',$type);
        update_option('woowa_reminder_time', $reminder_time);
    }else {
        $deprecated = null;
        $autoload = 'no';
        add_option('woowa_pesan_reminder_order', $pesan, $deprecated, $autoload );
        add_option('woowa_pesan_reminder_order1', $pesan, $deprecated, $autoload );
        add_option('woowa_pesan_reminder_order2', $pesan, $deprecated, $autoload );
        add_option('woowa_pesan_reminder_order3', $pesan, $deprecated, $autoload );
        add_option('woowa_on_hold_reminder_type',$type);
        add_option('on_hold_reminder',$batas_hari);
        add_option('woowa_reminder_time', $reminder_time);
    }

    if ( $reminder_diff_templates == 'check' ) {
        $reminder_diff_templates = "checked=checked";
        if ( get_option('woowa_reminder_diff_template') !== false ) {
            update_option('woowa_reminder_diff_template', $reminder_diff_templates);
        }else{
            add_option('woowa_reminder_diff_template', $reminder_diff_templates);
        }
    }else {
        update_option('woowa_reminder_diff_template', '');
    }

    if ( $reminder_loop == 'check' ) {
        $reminder_loop="checked=checked";
        if ( get_option('woowa_reminder_loop') !== false ) {
            update_option('woowa_reminder_loop', $reminder_loop);
        }else{
            add_option('woowa_reminder_loop', $reminder_loop);
        }
    }else {
    update_option('woowa_reminder_loop', '');
    }

    if ( $reminder_time == false ) {
        add_option('woowa_reminder_time', '00:00');
    }else {
        update_option('woowa_reminder_time', $reminder_time);
    }
	
    if(get_option('woowa_pesan_reminder_order' . $ke) == $pesan){
        $fb = 
        '<br>
            <div class="alert alert-success" role="alert">
            Data Saved.
        </div>';  
    }else {
	    $fb = 
        '<br>
            <div class="alert alert-danger" role="alert">
            Data Failed to Save.
        </div>';  
    }

    echo $fb;
    die();
}

function woowa_reminder_accordion(){
    $data = $_POST['data'];

    add_option('woowa_reminder_accordion', 'dinamichour');
    
    if ($data == 1) {
        update_option('woowa_reminder_accordion', 'fixedhour');
    }else {
        update_option('woowa_reminder_accordion', 'dinamichour');
    }
}

function woowa_wp_admin_style($hook){
    if (get_option('woowa_license') != 'active') {
        return ' ';
    }
    if ('edit.php' != $hook) {
        return;
    }
    wp_enqueue_style('woowa_css', plugins_url('../../public/css/woowa_order.css?v=0.1.21', __FILE__));
    wp_enqueue_style('fontawesome_css', 'https://use.fontawesome.com/releases/v5.4.2/css/all.css', __FILE__);
    wp_enqueue_style('bootstrap_css', plugins_url('../../public/css/bootstrap4.min.css?v=87', __FILE__));
}

function woowa_wp_admin_js($hook){
    if ('edit.php' != $hook) {
      return;
    }
    wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js');
    wp_enqueue_script('bootstrapcdn', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
    wp_enqueue_script('woowa_script1', plugins_url('pelanggan/public/js/woowa.js?v=5.1.5'));
}

function woowa_send_woowa_columns($columns){
    $columns['woowa-columns'] = __('Whatsapp Reminder', 'Woowa Button');

    return $columns;
}

function woowa_send_woowa_btn_column($column, $post_id){
    switch ($column) {
        case 'woowa-columns':
            echo '
            <div class="dropdown">
                <button class="btn btn-sm btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Send <i class="fab fa-whatsapp"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby=".dropdown-toggle">
                    <a href="#" class="dropdown-item a_reminder_btn btn-reminder-0" onclick="return ajax_force_reminder_order(this,'.$post_id.', 0)"> Default </a>
                    <a href="#" class="dropdown-item a_reminder_btn btn-reminder-1" onclick="return ajax_force_reminder_order(this,'.$post_id.', 1)"> Template 1 </a>
                    <a href="#" class="dropdown-item a_reminder_btn btn-reminder-2" onclick="return ajax_force_reminder_order(this,'.$post_id.', 2)"> Template 2 </a>
                    <a href="#" class="dropdown-item a_reminder_btn btn-reminder-3" onclick="return ajax_force_reminder_order(this,'.$post_id.', 3)"> Template 3 </a>
                </div>
            </div>';

        break;
    }
}

function woowa_force_reminder_order(){
    $ke = $_POST['ke'];
    $post_id = $_POST['post_id'];

    if (get_post_meta($post_id, 'bulk_template', true) !== false) {
        update_post_meta($post_id, 'bulk_template', $ke);
    } else {
        add_post_meta($post_id, 'bulk_template', $ke);
    }

    (get_option('woowa_license_type') == 'android') ? woowa_sendapi_cs_rotator('reminder_order', $post_id) : woowa_sendapi($post_id, 'reminder_order');
}

function woowa_reminder_message(){
    if(isset($_POST['data'])){
        $ke = $_POST['data']; 

        if ($ke == "0") {
            // update_option('woowa_reminder_message_type', $ke);
            $reminder['pesan'] = get_option('woowa_pesan_reminder_order');
            $reminder['gambar'] = get_option('woowa_pesan_reminder_order_gambar');
            $reminder['checkbox'] = get_option('woowa_check_reminder_order');
            die(json_encode($reminder));
        }else{
            // update_option('woowa_reminder_message_type', $ke);
            $reminder['pesan'] = get_option('woowa_pesan_reminder_order'.$ke);
            $reminder['gambar'] = get_option('woowa_pesan_reminder_order_gambar'.$ke);
            $reminder['checkbox'] = get_option('woowa_check_reminder_order'.$ke);
            die(json_encode($reminder));
        } 
    }else{
        // update_option('woowa_reminder_message_type', $ke);
        $reminder['pesan'] = get_option('woowa_pesan_reminder_order');
        $reminder['checkbox'] = get_option('woowa_check_reminder_order');
        return $reminder['pesan'];
    }
}


function woowa_onoff_reminder_order(){
    $toggle = $_POST['data'];

    if ( $toggle == '' ) {
        if( get_option('woowa_toggle_reminder_order') !== false ){
            update_option('woowa_toggle_reminder_order', $toggle);
        }else {
            add_option('woowa_toggle_reminder_order', $toggle);
        }
    }else {
        update_option('woowa_toggle_reminder_order', 'checked');
    }
}

function woowa_sendapi_reminder_order($order_id) {
    // woowa_writelog('xix1'); 
    $onhold_alias = get_option('woowa_onhold_alias');
    $reminder_accordion = get_option('woowa_reminder_accordion');

    $args = array(
        'limit' => '100',
        'status' => $onhold_alias,
        'date_created' => '>' . ( time() - WEEK_IN_SECONDS ),
    );
  
    if (function_exists('wc_get_orders')) {
        $orders = wc_get_orders( $args );
        $order_sent=array();

        if(isset($orders)){
            foreach ($orders as $k => $v) {
                if ($reminder_accordion == 'fixedhour') {
                    $hari_ini               = date('Y-m-d H:i');
                    $time                   = get_option('woowa_reminder_time');
                    $kirim_queue            = date('Y-m-d '. $time);
                    $reminder_loop          = get_option('woowa_reminder_loop');
                    $status_kirim           = get_post_meta($v->get_id(),'kirim_wa',true);
                    $terakhir_kirim         = get_post_meta($v->get_id(),'terakhir_kirim_wa', date('Y-m-d H:i:s'));
                    $reminder_time_terakhir = get_post_meta($v->get_id(), 'reminder_time_terakhir', true);

                if (empty($reminder_loop)) {
                    if ($hari_ini >= $kirim_queue) {
                        if ($status_kirim == 'belum' or empty($status_kirim) or $status_kirim==null) {
                            if(empty($status_kirim) or $status_kirim==null){
                                add_post_meta($v->get_id(),'kirim_wa','belum');
                            }
                        $order_sent[] = $v->get_id();
                        woowa_sendapi( $v->get_id(),'reminder_order');
                        update_post_meta($v->get_id(),'kirim_wa','sudah');
                        }
                    }
                }else {
                    $time = get_option('woowa_reminder_time');
                    $reminder_time_terakhir = get_post_meta($v->get_id(), 'reminder_time_terakhir', true);
                    $reminder_hari_ini = date('Y-m-d', strtotime($reminder_time_terakhir));
                    $tgl_ini = date('Y-m-d');
                    $jam_sekarang = date('H:i', strtotime($hari_ini));

                    if ($tgl_ini >= $reminder_hari_ini) {
                        if ($jam_sekarang >= $time) {
                        woowa_sendapi( $v->get_id(),'reminder_order');
                        $d = date('d', strtotime('1 days'));
                        $i = get_post_meta($v->get_id(), 'kirim_wa_ke', true);
                        $ke=$i+1;
                        ($ke > 4) ? $ke = 3 : NULL;
                        update_post_meta($v->get_id(), 'kirim_wa_ke', $ke);
                        update_post_meta($v->get_id(), 'reminder_time_terakhir', date('Y-m-' . $d . ' H:i'));
                        // woowa_writelog('#".$'->get_id()." $tgl_ini" . " $jam_sekarang >= $batas_hari $time--> sent WA");
                        }
                    }
                }
            
                }else {
                    $batas_hari = get_option('on_hold_reminder');
                    $reminder_loop = get_option('woowa_reminder_loop');
                    $reminder_type = get_option('woowa_on_hold_reminder_type');
                    $tgl_beli = date_create(date( 'Y-m-d H:i:s', strtotime($v->get_date_created()))); 
                    $hari_ini = date_create(date('Y-m-d H:i:s'));
                    $interval = date_diff($tgl_beli, $hari_ini);
                    
                    if (empty($batas_hari)) {
                        $batas_hari=2;
                    }
                    
                    if ($reminder_type == 'hour') {
                        $ini = date('Y-m-d H:i:s');
                        $terakhir_kirim = get_post_meta($v->get_id(),'terakhir_kirim_wa', date('Y-m-d H:i:s'));
                        $itu = date('Y-m-d H:i:s',strtotime('+'. $batas_hari .' hour',strtotime($terakhir_kirim)));
                        $kirim_nanti = $itu;
                    }else {
                        $ini = $interval->format('%d');
                        $itu = $batas_hari;
                    }
                    if(empty($reminder_loop)){
                        if ($reminder_type == 'hour') {
                            $batas_hari = $batas_hari;
                        }else {
                            $batas_hari = $batas_hari;
                        }
                        if($ini >= $itu){
                            $status_kirim=get_post_meta($v->get_id(),'kirim_wa',true);

                            if ($status_kirim=='belum' or empty($status_kirim) or $status_kirim==null) {
                                if(empty($status_kirim) or $status_kirim==null){
                                    add_post_meta($v->get_id(),'kirim_wa','belum');
                                }
                                $order_sent[]=$v->get_id();
                                woowa_sendapi( $v->get_id(),'reminder_order');
                                update_post_meta($v->get_id(),'kirim_wa','sudah');
                            }
                        }
                    }else {
                        if ($reminder_type == 'hour') {
                            $hari_ini = date('Y-m-d H:i:s');
                            $ini = $hari_ini;
                            $itu = $kirim_nanti;
                        }else {
                            $terakhir_kirim = get_post_meta($v->get_id(),'terakhir_kirim_wa', date('Y-m-d H:i:s'));
                            $hari_ini = date('Y-m-d H:i:s');
                            $ini = $hari_ini;
                            $itu = $batas_hari;
                            $itu = date('Y-m-d H:i:s', strtotime($terakhir_kirim . ' + '. $batas_hari .' days'));
                        }
                    
                        if ($ini >= $itu) {
                            update_post_meta($v->get_id(),'kirim_wa','belum');
                            woowa_sendapi( $v->get_id(),'reminder_order');
                            $i = get_post_meta($v->get_id(), 'kirim_wa_ke', true);
                            ($i >= 3) ? $ke = 3 : $ke=$i+1;
                            update_post_meta($v->get_id(),'kirim_wa_ke', $ke);
                            update_post_meta($v->get_id(),'terakhir_kirim_wa', date('Y-m-d H:i:s'));
                            update_post_meta($v->get_id(),'kirim_wa','sudah');
                        }
                    }

                    if (count($order_sent) != 0) { 
                        foreach ($order_sent as $k => $id) {
                            // echo get_post_meta($get_id(),'kirim_wa',true)." di kirim on-hold id $id<br>";
                            if(get_post_meta($id,'kirim_wa',true)=='belum'){
                            // woowa_sendapi( $id,'reminder_order');
                            // update_post_meta($id,'kirim_wa','sudah');
                            }
                        }
                    }
                }
            } 	
        }
    }
}