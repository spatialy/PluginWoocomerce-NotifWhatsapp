<?php

function woowa_order_process_view(){
if (get_option('woowa_license')!='active') { return ('<br>please activate license code. click <a href="#license"  data-toggle="tab" aria-expanded="true">here</a>');}
	$view='';
    $toggle_order_process = get_option('woowa_toggle_order_process');
    if ($toggle_order_process != 'checked') {
    	$hide='style="display:none;"';
    }else{
    	$hide='';
    }
    $view.='

    <form method="post" id="form_order_process" '. $hide .'>
    <div id="content_order_process">
    <div style="float:left;">
    	
    <h3>Template WA Message : </h3>
    <input type="hidden" name="action" value="save_order_process" >
    <textarea class="template-wa"  name="pesan_order_process" id="wa-after">';
    $view.=get_option('woowa_pesan_order_process');

    $gambar = get_option('woowa_image_order_process');
    $checked = get_option('woowa_check_order_process');

    $view.='</textarea>
	    
    <br style="clear:both;">';
        if (get_option('woowa_license_type') != 'android') {
            // $view.='<input type="checkbox" value="check" name="checkboximage" '. $checked .' class="cbx" >
            // <span class="fas fa-paperclip"></span> attach picture : 
            // <input class="imginput" type="text" id="image_order_process" name="image" value="'. $gambar .'" placeholder="https://xyz.com/img.jpg" >
            // &nbsp;&nbsp; or <input type="file" id="file_order_process" style="width: 94px;float:right;"/>';
        }
    $view.='
    <br>
    <br>
    <div class="btn-save" style="float:left;">
	    <button onclick="return ajax_order_process()" name="simpan_order_process" class="btn btn-success" >  Save  </button>
	</div>
	<br><br><br>
	<div id="notif_order_process"></div>
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
    $script = woowa_script_order_process_view();
    return $view.$script;

}

?>