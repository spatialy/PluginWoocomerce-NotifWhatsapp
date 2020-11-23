<?php

function woowa_pending_payment_view(){
if (get_option('woowa_license')!='active') { return ('<br>please activate license code. click <a href="#license"  data-toggle="tab" aria-expanded="true">here</a>');}
	$view='';
    $toggle_pending_payment = get_option('woowa_toggle_pending_payment');
    if ($toggle_pending_payment != 'checked') {
    	$hide='style="display:none;"';
    }else{
    	$hide='';
    }
    $view.='

    <form method="post" id="form_pending_payment" '. $hide .'>
    <div id="content_pending_payment">
    <div style="float:left;">
    	
    <h3>Template WA Message : </h3>
    <input type="hidden" name="action" value="save_pending_payment" >
    <textarea class="template-wa"  name="pesan_pending_payment" id="wa-after">';
    $view.=get_option('woowa_pesan_pending_payment');

    $gambar = get_option('woowa_image_pending_payment');
    $checked = get_option('woowa_check_pending_payment');

    $view.='</textarea>
	    
        <br style="clear:both;">';
        if (get_option('woowa_license_type') != 'android') {
            // $view.='<input type="checkbox" value="check" name="checkboximage" '. $checked .' class="cbx" >
            // <span class="fas fa-paperclip"></span> attach picture : 
            // <input class="imginput" type="text" id="image_pending_payment" name="image" value="'. $gambar .'" placeholder="https://xyz.com/img.jpg" >
            // &nbsp;&nbsp; or <input type="file" id="file_pending" style="width: 94px;float:right;"/>';
        }
    $view.='
    <br>
    <br>
    <div class="btn-save" style="float:left;">
        <button onclick="return ajax_pending_payment()" name="simpan_pending_payment" class="btn btn-success" >  Save  </button>
	</div>
	<br><br><br>
	<div id="notif_pending_payment"></div>
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
    $script = woowa_script_pending_payment_view();
    return $view.$script;

}

?>