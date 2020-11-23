<?php

function woowa_order_refund_view(){
if (get_option('woowa_license')!='active') { return ('<br>please activate license code. click <a href="#license"  data-toggle="tab" aria-expanded="true">here</a>');}
	$view='';
    $toggle_order_refund = get_option('woowa_toggle_order_refund');
    if ($toggle_order_refund != 'checked') {
    	$hide='style="display:none;"';
    }else{
    	$hide='';
    }
    $view.='

    <form method="post" id="form_order_refund" '. $hide .'>
    <div id="content_order_refund">
    <div style="float:left;">
    	
    <h3>Template WA Message : </h3>
    <input type="hidden" name="action" value="save_order_refund" >
    <textarea class="template-wa"  name="pesan_order_refund" id="order_refund">';
    $view.=get_option('woowa_pesan_order_refund');

    $gambar = get_option('woowa_image_order_refund');
    $checked = get_option('woowa_check_order_refund');

    $view.='</textarea>
	<br style="clear:both;">';
        if (get_option('woowa_license_type') != 'android') {
            // $view.='<input type="checkbox" value="check" name="checkboximage" '. $checked .' class="cbx" >
            // <span class="fas fa-paperclip"></span> attach picture : 
            // <input class="imginput" type="text" id="image_order_refund" name="image" value="'. $gambar .'" placeholder="https://xyz.com/img.jpg" >
            // &nbsp;&nbsp; or <input type="file" id="file_refund" style="width: 94px;float:right;"/>';
        }
    $view.='
    <br>
    <br>
    <div class="btn-save" style="float:left;">
	    <button onclick="return ajax_order_refund()" name="simpan_order_refund" class="btn btn-success" >  Save  </button>
	</div>
	<br><br><br>
	<div id="notif_order_refund"></div>
    </div>

    <style>
        #shortcode-reference td{
            font-size:12px;
            padding-left:20px;
        }
    </style>

    '.woowa_shortcode_reference('en').'

    </form>
    </div>

    '

    ;
    $script = woowa_script_order_refund_view();
    return $view.$script;

}

?>