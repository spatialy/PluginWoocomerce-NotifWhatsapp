<?php

function woowa_cancel_order_view(){
  $view = '';
  $checked = get_option('woowa_check_cancel_order');
  $gambar = get_option('woowa_image_cancel_order');
  if (get_option('woowa_license')!='active') { return ('<br>please activate license code. click <a href="#license"  data-toggle="tab" aria-expanded="true">here</a>');}
    $toggle_cancel_order = get_option('woowa_toggle_cancel_order');
    if ($toggle_cancel_order != 'checked') {
    	$hide='style="display:none;"';
    }else{
    	$hide='';
    }

	  $script = woowa_script_cancel_order_view();
    $view.='
    <form method="post" id="form_cancel_order" '. $hide .'>
    <div id="content_cancel_order">
    <div style="float:left;">

    <h3 style="color: black;">Template WA Message : </h3>
    <input type="hidden" name="action" value="save_cancel_order" >
    <textarea class="template-wa" name="pesan_cancel_order" id="pesan_cancel_order">';
    $view.=get_option('woowa_pesan_cancel_order');
    $view.='</textarea>
      <br style="clear:both;">';
      if (get_option('woowa_license_type') != 'android') {
        // $view.='<input type="checkbox" value="check" name="checkboximage" '. $checked .' class="cbx" >
        // <span class="fas fa-paperclip"></span> attach picture : 
        // <input class="imginput" type="text" name="image" id="image_cancel_order" value="'. $gambar .'" placeholder="https://xyz.com/img.jpg" >
        // &nbsp;&nbsp; or <input type="file" id="file_cancel_order" style="width: 94px;float:right;"/>';
      }
    $view.='<br>
      <div class="btn-save" style="float:left;">
        <button onclick="return ajax_cancel_order()" name="simpan_cancel_order" class="btn btn-success">  Save  </button>
      </div>
      <br><br><br>
      <div id="notif_cancel_order"></div>
      
        
    </div>

    <style>
        #shortcode-reference td{
            font-size:12px;
            padding-left:20px;
        }
    </style>

    '.woowa_shortcode_reference('en').'
    </form>
    </div>'
    ;
    return $view.$script;
}