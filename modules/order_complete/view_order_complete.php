<?php

function woowa_order_complete_view(){
  $view='';
  $gambar = get_option('woowa_image_order_complete');
  $checked = get_option('woowa_check_order_complete');
  $toggle_followup = get_option('woowa_checkbox_followup');

  if (get_option('woowa_license')!='active') { return ('<br>please activate license code. click <a href="#license"  data-toggle="tab" aria-expanded="true">here</a>');}
    $toggle_order_complete = get_option('woowa_toggle_order_complete');
    if ($toggle_order_complete != 'checked') {
    	$hide='style="display:none;"';
    }else{
    	$hide='';
    }

    $batas_hari = get_option("woowa_order_completed_followup");
    (empty($batas_hari)) ? $batas_hari = 2 : $batas_hari = $batas_hari;

    $type = get_option("woowa_order_completed_followup_type");
    (empty($type)) ? $type = "day" : $type;

	  $script = woowa_script_order_complete_view();
    $view.=' 
    <form method="post" id="form_order_complete" '. $hide .'>
    <input type="hidden" name="ke_order_completed" id="ke_order_completed" value="0" >
    <input type="hidden" name="action" value="save_order_complete" >
    <div id="content_order_complete">
    <div style="float:left;">

    <h3 style="color: black;">Template WA Message : <span class="loading-order-completed-message"></span></h3>
    <style>
      .btn-success:hover {
        background-color: #9b5c8f;
        border-color: #9b5c8f;
      }
      .order-completed-btn{
        background:#5cb85c;
        border-color: #4cae4c;
      }
      .order-completed-btn-active{
        background:#9b5c8f !important;
        border-color: #9b5c8f !important;
      }
    </style>
    <br>
    <button onclick="return ajax_order_completed_message(this, 0)" name="order_completed_message0" class="btn btn-success order-completed-btn order-completed-btn-active">  Order Completed  </button>
    <button onclick="return ajax_order_completed_message(this, 1)" name="order_completed_message1" class="btn btn-success order-completed-btn">  Follow Up  </button> 
    <br><br>
    <textarea class="template-wa template-wa-order_completed" name="pesan_order_complete" id="template-wa-order_completed">';
    $view.=woowa_order_completed_message();
    
    if (empty(get_option('woowa_check_order_complete'))) {
      $z = '';
    }else {
      $z = get_option('woowa_check_order_complete');
    }

    $view.='</textarea>
      <br style="clear:both;">';
      if (get_option('woowa_license_type') != 'android') {
        // $view.='<input type="checkbox" value="checked" name="checkboximage"  '. $z .' class="cbx" id="cek_img_order_completed">
        // <span class="fas fa-paperclip"></span> attach picture : 
        // <input class="imginput" type="text" name="image" id="image_order_complete" value="'. $gambar .'" placeholder="https://xyz.com/img.jpg" >
        // &nbsp;&nbsp; or <input type="file" id="file_order_complete" style="width: 94px;float:right;"/>';
      }
      $view.='
      <br><br>
        <div class="bs-example">
          <div class="panel-group" id="followup_accordion" puthere>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#followup_accordion" href="#followupcollapse" value="dinamic" >
                      Followup Message Time <span class="badge badge-pill badge-info">Klik To Setting</span>
                    </a>
                    </h4>
                </div>
                <div id="followupcollapse" class="panel-collapse collapse">
                    <div class="panel-body" style="background: black;">
                      Followup Message will be sent after : <input type="number" min="0" oninput="validity.valid||(value=\'\');"  style="width:50px;margin-bottom:5px;" name="batas_hari" value="'.$batas_hari.'" /> 
                      <select name="types"><option value="'. $type .'">'. $type .'</option><option value="day">day</option><option value="hour">hour</option></select>  <input type="checkbox" '.$toggle_followup.' data-toggle="toggle" data-size="small" data-onstyle="success" name="toggle_followup">
                    </div>
                </div>
            </div>
          </div>
        </div>
      <div class="btn-save" style="float:left;">
        <button onclick="return ajax_order_complete()" name="simpan_order_complete" class="btn btn-success">  Save  </button>
      </div>
      <br><br><br>
      <div id="notif_order_complete"></div>
      
        
    </div>

    <style>
        #shortcode-reference td{
            font-size:12px;
            padding-left:20px;
        }
    </style>
    <br><br><br><br>

    '.woowa_shortcode_reference('en').'
    </form>
    </div>'
    ;
    return $view.$script;
}
?>