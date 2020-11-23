<?php

function woowa_custom_form_view($custom_form_id){
    $html='';
    $toggle_custom_form = get_option('woowa_toggle_custom_form'.$custom_form_id);
    $noseller = get_option('woowa_number_cf_seller_notification'.$custom_form_id);
    if (get_option('woowa_license') != 'active') {
        return '<br>please activate license code. click <a href="'.site_url().'/wp-admin/admin.php?page=pelanggan-net-settings"  aria-expanded="true">here</a>';
      }
    if ($toggle_custom_form == '') {
    	$hide='style="display:none;"';
    }else{
    	$hide='';
    }

    $form_id = get_option('woowa_form_id_custom_form'.$custom_form_id);
    $field_no_hp_id = get_option('woowa_field_no_hp_id_custom_form'.$custom_form_id);
    $gambar = get_option('woowa_image_custom_form'.$custom_form_id);
    $checked = get_option('woowa_check_custom_form'.$custom_form_id);
  
    $html.= '
    <div id="btn_toggle_custom_form">
        <h3>Template WA Message : </h3>
    </div>
    <br style="clear:both;">
    <div id="content_custom_form">
        <form method="post" id="form_custom_form'.$custom_form_id.'" '. $hide .'>
        <input type="hidden" name="custom_form_id" class="custom_form_id" value="'. $custom_form_id .'">
            <div style="float:left;">
                <input type="hidden" name="action" value="save_custom_form" >
                <div style="margin-bottom:5px;">form id : <input type="text" name="form_id" value="'. $form_id .'" placeholder="woowa" ></div>
                phone number field name : <input type="text" name="field_no_hp_id" value="'. $field_no_hp_id .'" placeholder="form_fields[no-wa]" ><br>
                <textarea class="template-wa"  name="pesan_custom_form" style="width: 100%;
                    height: 200px;
                    border: 1px solid #ddd;
                    box-sizing: border-box;">';
                $html.=get_option('woowa_pesan_custom_form'.$custom_form_id);
                $html.='</textarea>
                <br style="clear:both;">';
                if (get_option('woowa_license_type') != 'android') {
                    // $html.='<input type="checkbox" value="check" name="checkboximage" '. $checked .' class="cbx" >
                    // <span class="fas fa-paperclip"></span> attach picture : 
                    // <input type="text" class="image_custom_form" name="image" value="'. $gambar .'" placeholder="https://xyz.com/img.jpg" >
                    // &nbsp;&nbsp; or <input type="file" id="file" style="width: 94px;float:right;"/>';
                }
                
                $html .='
                <br><br>

                <h4>Seller Notification : </h4>
                <textarea class="template-wa" name="pesan_cf_seller_notification">';
                $html.=get_option('woowa_pesan_cf_seller_notification'.$custom_form_id);
                $html.='</textarea>
                <br style="clear:both;">
                WhatsApp Seller Number :
                <br>
                <input class="" type="text" name="noseller'.$custom_form_id.'" value="'. $noseller .'" >

                <br><br>
                <div class="btn-save" style="float:left;">
                    <button onclick="return ajax_custom_form('.$custom_form_id.')" name="simpan_custom_form" class="btn btn-success" >  Save  </button>
                </div>
                <br><br><br>
                <div id="notif_custom_form'.$custom_form_id.'"></div>
            </div>
            '.woowa_shortcode_custom_form($custom_form_id).'
        </form>
    </div>';

    return $html;
}

function woowa_shortcode_custom_form($id){
    $url=get_option('woowa_custom_form_scan_url');
    if (strlen($url)>30) {
        $url_short=substr($url,0,30).'..';
    }else{
        $url_short=$url;
    }

    $html='
    <div style="float:left;padding-left:10px;"><br><br>
    <h3>scan form by URL :</h3> <input type="text" name="custom_form_url" class="custom_form_url'.$id.'">
    <button class="btn btn-sm btn-default" onclick="return ajax_scan_url('.$id.')">Scan</button><br><br>
    url : <a class="url_scan" href="'.$url.'"  title="'.$url.'" >'.$url_short.'</a>
    <div class="result_scan">

    '.get_option('woowa_custom_form_scan_url_response');

    $html.='</div></div>';

    return $html;

}