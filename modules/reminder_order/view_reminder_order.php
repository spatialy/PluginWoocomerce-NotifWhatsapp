<?php

function woowa_reminder_order_view(){
  $reminder_time = get_option("woowa_reminder_time");
  $reminder_loop = get_option('woowa_reminder_loop');
  $gambar = get_option('woowa_pesan_reminder_order_gambar');
  // $checked = woowa_reminder_checbox();
  $reminder_diff_template = get_option("woowa_reminder_diff_template");
  // $reminder_time = get_option('woowa_reminder_time');
  // $reminder_time = date('H:i');
  $script = woowa_script_reminder_order_view();
  if (get_option('woowa_license')!='active') { return ('<br>please activate license code. click <a href="#license" data-toggle="tab" aria-expanded="true">here</a>');}
    $toggle_reminder_order = get_option('woowa_toggle_reminder_order');
    if ($toggle_reminder_order != 'checked') {
    	$hide='style="display:none;"';
    }else{
    	$hide='';
    }

    $view='';
    $view.='
    <form method="post" id="form_reminder_order" '. $hide .'>
      <input type="hidden" name="ke" id="ke" value="0" >
      <input type="hidden" name="action" value="save_reminder_order" >
      <h3 style="color: black;">Template WA Message : <span class="loading-reminder-message"></span></h3>
      <div id="content_reminder_order">
      <div style="float:left;">
      <style>
        .btn-success:hover {
          background-color: #9b5c8f;
          border-color: #9b5c8f;
        }
        .reminder-btn{
          background:#5cb85c;
          border-color: #4cae4c;
        }
        .reminder-btn-active{
          background:#9b5c8f !important;
          border-color: #9b5c8f !important;
        }
      </style>
      <br>
      <button onclick="return ajax_reminder_message(this, 0)" name="reminder_message0" class="btn btn-success reminder-btn reminder-btn-active">  Default  </button>
      <button onclick="return ajax_reminder_message(this, 1)" name="reminder_message1" class="btn btn-success reminder-btn">  Template 1  </button> 
      <button onclick="return ajax_reminder_message(this, 2)" name="reminder_message2" class="btn btn-success reminder-btn">  Template 2  </button>
      <button onclick="return ajax_reminder_message(this, 3)" name="reminder_message3" class="btn btn-success reminder-btn">  Template 3  </button>
      <br><br>
      <textarea class="template-wa template-wa-reminder" name="pesan_reminder_order">';

      $view.= woowa_reminder_message();
      $batas_hari = get_option("on_hold_reminder");
      if (empty($batas_hari)) {
        $batas_hari = 2;
      }

      $type=get_option("woowa_on_hold_reminder_type");
      if (empty($type)) {
        $type = "day";
      }
    
      $accordion = get_option('woowa_reminder_accordion');

      if ($accordion == "fixedhour") {
        $in = "in";
        $in2 = "";
      }else {
        $in = "";
        $in2 = "in";
      }

      if (empty(get_option('woowa_check_reminder_order'))) {
        $z = '';
      }else {
        $z = get_option('woowa_check_reminder_order');
      }
      
      if (get_option('woowa_reminder_loop')=='checked=checked') {
        $show_hide_diff_templates='';
      }else {
        $show_hide_diff_templates='style="display:none;"';
      }
      // puthere
      // <div class="panel panel-default">
      //           <div class="panel-heading">
      //               <h4 class="panel-title">
      //                   <a data-toggle="collapse" data-parent="#time_accordion" href="#collapseOne" onclick="return ajax_reminder_accordion(1)">
      //                     Reminder for specific hours
      //                   </a>
      //               </4>
      //           </div>
      //           <div id="collapseOne" class="panel-collapse collapse '.$in.' ">
      //               <div class="panel-body">
      //                 Reminder will be sent every : <input type="time" style="width:110px;margin-bottom:5px;" name="reminder_time" value="'.$reminder_time.'" />
      //               </div>
      //           </div>
      //       </div>
      $view.='</textarea>
        <br>
        <br style="clear:both;">';
        if (get_option('woowa_license_type') != 'android') {
          // $view.='<input type="checkbox" class="cbx" value="checked" name="checkboximage" id="cek_img_reminder" '. $z .'>
          // <span class="fas fa-paperclip"></span> attach file/image : 
          // <input class="imginput" type="text" name="image" id="image_reminder_order" value="'. $gambar .'" placeholder="https://xyz.com/img.jpg" >
          // &nbsp;&nbsp; or <input type="file" id="file_reminder_order" style="width: 94px;float:right;"/>';
        }
        $view.='
        <br>
        <br>
        <div class="bs-example">
          <div class="panel-group" id="time_accordion" puthere>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#time_accordion" href="#collapseTwo" value="dinamic" onclick=" return ajax_reminder_accordion(2) ">
                      Reminder for specific periods <span class="badge badge-pill badge-info">Klik To Setting</span>
                    </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse '.$in2.' ">
                    <div class="panel-body" style="background: black;">
                      Reminder will be sent after : <input type="number" min="0" oninput="validity.valid||(value=\'\');"  style="width:50px;margin-bottom:5px;" name="batas_hari" value="'.$batas_hari.'" /> 
                      <select name="types"><option value="'. $type .'">'. $type .'</option><option value="day">day</option><option value="hour">hour</option></select>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <input type="checkbox" value="check" name="reminder_loop" '. $reminder_loop .' class="cbx" onclick="return cek_diff_template(this);"> <span style="color: black;">Send messages repeatedly</span>
        <div id="div_diff_templates" '.$show_hide_diff_templates.'>
          <input type="checkbox" value="check" name="diff_templates" '. $reminder_diff_template .' class="cbx" > <span style="color: black;">Use different templates for every reminder</span>
        </div>
        
        <br>
        <div class="btn-save" style="float:left;">
          <button onclick="return ajax_reminder_order()" name="simpan_reminder_order" class="btn btn-success">  Save  </button>
        </div>
        <br><br><br>
        <div id="notif_reminder_order"></div><br>
      </div>

      <style>
          #shortcode-reference td{
              font-size:12px;
              padding-left:20px;
          }
      </style><br>

      '.woowa_shortcode_reference('en').'
      </div>
    </form>
    ';

    return $view.$script;
}