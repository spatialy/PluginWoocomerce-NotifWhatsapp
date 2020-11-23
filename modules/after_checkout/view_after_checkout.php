<?php

function woowa_after_checkout_view(){
    if (get_option('woowa_license')!='active') { return ('<br>please activate license code. click <a href="#license"  data-toggle="tab" aria-expanded="true">here</a>');}
	$view='';
    $toggle_after_checkout = get_option('woowa_toggle_after_checkout');
    if ($toggle_after_checkout != 'checked') {
    	$hide='style="display:none;"';
    }else{
    	$hide='';
    }
    $view.='

    <form method="post" id="form_after_checkout" '. $hide .'>
    <div id="content_after_checkout">
    <div style="float:left;" >
    	
    <h3>Template WA Message : </h3>
    <input type="hidden" name="action" value="save_after_checkout" >
    <textarea class="template-wa"  name="pesan_after_checkout" id="after_checkout_textarea">';
    $view.=get_option('woowa_pesan_after_checkout');

    $gambar = get_option('woowa_image_after_checkout');
    $checked = get_option('woowa_check_after_checkout');

    $view.='</textarea>
    <br style="clear:both;">';
        if (get_option('woowa_license_type') != 'android') {
            // $view.='<input type="checkbox" value="check" name="checkboximage" '. $checked .' class="cbx" >
            // <span class="fas fa-paperclip"></span> attach picture : 
            // <input class="imginput" type="text" id="image" name="image" value="'. $gambar .'" placeholder="https://xyz.com/img.jpg" >
            // &nbsp;&nbsp; or <input type="file" id="file" style="width: 94px;float:right;"/>';
        }
    $view.='<br>
		<br>
		<div class="btn-save" style="float:left;">
            <button onclick="return ajax_after_checkout()" name="simpan_after_checkout" class="btn btn-success" >  Save  </button>
	    </div>
	<br><br><br>
	<div id="notif_after_checkout"></div>
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
    $script = woowa_script_after_checkout_view();
    return $view.$script;

}

?>