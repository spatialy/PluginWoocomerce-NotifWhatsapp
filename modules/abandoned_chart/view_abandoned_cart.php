<?php

function woowa_abandoned_cart_view(){
    $view = '';
    $toggle_abandoned_cart = get_option('woowa_toggle_abandoned_cart');
    if ($toggle_abandoned_cart != 'checked') {
    	$hide='style="display:none;"';
    }else{
        $hide = '';
    }
    $view .= '

    <form method="post" id="form_abandoned_cart" '.$hide.'>
    <div id="content_abandoned_cart">
    <div style="float:left;">
    	
    <h3>Template WA Message : </h3>
    <input type="hidden" name="action" value="save_abandoned_cart" >
    <textarea class="template-wa"  name="pesan_abandoned_cart" id="wa-after">';
    $view .= get_option('woowa_pesan_abandoned_cart');

    $gambar = get_option('woowa_image_abandoned_cart');
    $checked = get_option('woowa_check_abandoned_cart');

    $view .=  '</textarea>
	    
        <br style="clear:both;">';
        if (get_option('woowa_license_type') != 'android') {
            // $view.='<input type="checkbox" value="check" name="checkboximage" '.$checked.' class="cbx" >
            // <span class="fas fa-paperclip"></span> attach picture : 
            // <input class="imginput" type="text" id="image_abandoned_cart" name="image" value="'.$gambar.'" placeholder="https://xyz.com/img.jpg" >
            // &nbsp;&nbsp; or <input type="file" id="file" style="width: 94px;float:right;"/>';
        }
        
    $view.='<br>
		<br>
		<div class="btn-save" style="float:left;">
            <button onclick="return ajax_abandoned_cart()" name="simpan_abandoned_cart" class="btn btn-success" >  Save  </button>
	    </div>
	<br><br><br>
	<div id="notif_abandoned_cart"></div>
    </div>

    <style>
        #shortcode-reference td{
            font-size:12px;
            padding-left:20px;
        }
    </style>

    '.woowa_shortcode_reference('en').'

    </div>
    </form>

    '

    ;
    $script = woowa_script_abandoned_cart_view();

    return $view.$script;
}
