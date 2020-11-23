<?php

function woowa_get_allstatus_template(){
  $script = woowa_script_seller_notification_view();
  $array_seller = get_option('woowa_seller_service_data');
  $array_seller = json_decode($array_seller,1);
  $toggle_seller_notification_setting = get_option('woowa_toggle_seller_notification_setting');
  //woowa_prepre($array_seller);
  if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
    $lotsOfStatus = wc_get_order_statuses();
  }else {
    $lotsOfStatus = array();
  }

  $view='';
  if ($toggle_seller_notification_setting != 'checked') {
    $hide='style="display:none;"';
  }else{
    $hide='';
  }

  $view.='
  <div class="panel panel-success">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#seller_notification_setting_accordion" value="dinamic"  style="display:block;" >Seller Notification Settings <span class="badge badge-pill badge-info">Klik To Setting</span></a>
        <div class="on_off_container">
          <input type="checkbox" '.$toggle_seller_notification_setting.' data-size="mini" data-toggle="toggle" name="onoff_seller_notification_setting" class="onoff_seller_notification_setting" id="onoff_seller_notification_setting" data-off="OFF" data-on="ON" data-onstyle="success"  data-offstyle="danger">        
        </div>
      </h4>
    </div>
    <div id="seller_notification_setting_accordion" class="panel-collapse collapse ">
        <div class="panel-body">
          <form method="post" id="form_seller_notification_setting" '. $hide .'>
            <div id="content_seller_notification_setting">
              <div>
              <div><button class="btn btn-sm btn-success" style="margin-bottom:10px;" data-toggle="modal" type="button" data-target="#addsellernotif" onclick=jQuery("#whatsapp-form").val(""); >Add Number</button></div>
              <div>
                <table class="table" style="border:none;">
                  <thead>'.woowa_pop_up();
              if (!empty($array_seller)){
                $view.='WhatsApp Seller Number :
                      <tr>
                        <th scope="col">Seller</th>
                        <th scope="col" width="850px">Selected Template</th>
                        <th scope="col">WA Number</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody class="tbody-seller" style="background: white">';
                $array_seller = get_option('woowa_seller_service_data');
                $array_seller = json_decode($array_seller,1);
                // woowa_prepre($array_seller);
                // unset($array_seller);
                if (!empty(get_option('woowa_seller_service_data'))) {
                  foreach ($array_seller as $key => $value) {
                    $id = $key;
                    $name = $value['name'];
                    $select = $value['select'];
                    $selected = explode(",", $select);
                    if (in_array('all', $selected)) {
                      $select = "All Templates";
                    }
                    $select = str_replace("_", " ", $select);
                    $select = str_replace(",", ", ", $select);
                    $wa_seller = $value['wa_number'];
                    $toggle_seller = get_option('woowa_toggle_seller_list'.$id);
                    $view .= '
                      <tr id="seller_'.$id.'">
                        <td class="seller_notif_name" id="seller_notif_name'.$id.'">
                          '.$name.'
                        </td>
                        <td class="seller_notif_select" id="seller_notif_select'.$id.'">
                          '.ucwords($select).'
                        </td>
                        <td class="seller_notif_no_wa" id="seller_notif_no_wa'.$id.'">
                          <span>'.$wa_seller.'</span>
                        </td>';
                    $view.='
                        <td data-seller-notif-id="'.$id.'">
                          <button class="btn btn-xs btn-primary" type="button" style="margin-left:10px; margin-bottom:2px;" data-toggle="modal" data-target="#updatesellernotif'.$id.'" ><i class="fas fa-pencil-alt"></i></button>
                          <button class="btn btn-xs btn-danger" type="button" style="margin-left:10px; margin-bottom:2px; margin-right:10px;" data-toggle="modal" data-target="#deletesellernotif" onclick="pop_up_seller_notif('. $id .')"><i class="far fa-trash-alt"></i></button>
                          <input type="checkbox" '.$toggle_seller.' id="toggle_seller'.$id.'" data-toggle="toggle" data-size="mini" class="toggle-seller-list">
                        </td>
                      </tr>'.update_seller_notif($id, $name, $wa_seller, $selected);
                  }
                }
              }
            $view.='</tbody>
                  </table>
                </div>
              </div>
            </div>';
            $toggleaf = get_option('woowa_toggle_seller_notificationafter_checkout');

            $view.='<h3 style="color: black;">Seller Notification Templates</h3>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion_after_checkout_seller_notif" href="#after_checkout_seller_notif_accordion" value="dinamic"  style="display:block;" >After Checkout <span class="badge badge-pill badge-info">Klik To Setting</span></a>
                <div class="on_off_container" data-toggle-seller-status="after_checkout" id="after_checkout">
                  <input type="checkbox" '.$toggleaf.' data-size="mini" data-toggle="toggle" name="onoff_seller_notificationafter_checkout" class="onoff_seller_notification" data-off="OFF" data-on="ON" data-onstyle="success"  data-offstyle="danger">        
                </div>
                </h4>
              </div>
              <div id="after_checkout_seller_notif_accordion" class="panel-collapse collapse ">
                <div class="panel-body" style="background: black;">
                '.woowa_seller_notification_view('after_checkout', '').'
                </div>
              </div>
            </div>';
        
          foreach ($lotsOfStatus as $key => $value) {
            $statuses = str_replace("wc-", "", $key);
            $status_name = str_replace("-", "_", $statuses);
            $check = get_option('woowa_check_'.$status_name);
            $toggle = get_option('woowa_toggle_seller_notification'.$status_name);
            
            $view.='
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion_'.$status_name.'" href="#'.$status_name.'_accordion" value="dinamic"  style="display:block;" >'.$value.' <span class="badge badge-pill badge-info">Klik To Setting</span></a>
                  <div class="on_off_container" data-toggle-seller-status="'.$status_name.'" id="img_" value="'.$status_name.'">
                    <input type="checkbox" '.$toggle.' data-size="mini" data-toggle="toggle" name="onoff_seller_notification'.$status_name.'" class="onoff_seller_notification" data-off="OFF" data-on="ON" data-onstyle="success"  data-offstyle="danger">        
                  </div>
                  </h4>
                </div>
                <div id="'.$status_name.'_accordion" class="panel-collapse collapse ">
                  <div class="panel-body" style="background: black;">
                  '.woowa_seller_notification_view($status_name, '').'
                  </div>
                </div>
              </div>';
          }
            $view.='
            </div>
          </form>
      </div>
    </div>';

  return $view.$script;
}

function woowa_seller_notification_view($template_name, $type_seller=''){
  $view = '';
  $checked = get_option('woowa_check_image_seller_notification'.$template_name.'');
  $gambar = get_option('woowa_image_seller_notification'.$template_name.'');
  if (get_option('woowa_license')!='active') { return ('<br>please activate license code. click <a href="#license"  data-toggle="tab" aria-expanded="true">here</a>');}
    $toggle_seller_notification = get_option('woowa_toggle_seller_notification'.$template_name.'');
    if ($toggle_seller_notification != 'checked') {
      $hide='style="display:none;"';
    }else{
      $hide='';
    }
    // <input type="checkbox" '.$toggle_seller_notification'.$template_name.'.'  data-toggle="toggle" name="onoff_seller_notification'.$template_name.'" id="onoff_seller_notification'.$template_name.'" data-off="OFF" data-on="ON" data-onstyle="success"  data-offstyle="danger">
    // <p>Turn On to send your message</p>
    $view.='
    <form method="post" id="form_seller_notification'.$template_name.'" '. $hide .'>
    <input type="hidden" name="tipe" id="tipe" value="'.$template_name.'" >
    <div id="content_seller_notification'.$template_name.'">
    <div style="float:left;background: black;">

    <h3>Template WA Message : <span class="loading-seller-message"></span></h3>
    <input type="hidden" name="action" value="save_seller_notification" >
    <textarea style="background: gray;" class="template-wa-seller" name="pesan_seller_notification'.$template_name.'">';
    $view.=get_option('woowa_pesan_seller_notification'.$template_name);
    $i=1;
    $i++;
    $view.='</textarea>
      <br style="clear:both;">';
      
      if (get_option('woowa_license_type') != 'android') {
      //   $view.='
      // <input type="checkbox" id="cbx-image-'.$template_name.'" class="cbx" style="display: none;" value="check" name="checkboximage'.$template_name.'" '. $checked .'>
      //   <label for="cbx-image-'.$template_name.'" class="check">
      //     <svg width="18px" height="18px" viewBox="0 0 18 18">
      //       <path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
      //       <polyline points="1 9 7 14 15 4"></polyline>
      //     </svg>
      //   </label>
      //   <span class="fas fa-paperclip"></span> attach picture : 
      //   <input class="imginput" type="text" name="image'.$template_name.'" id="image_seller_notification'.$i.'" value="'. $gambar .'" placeholder="https://xyz.com/img.jpg" >
      //   &nbsp;&nbsp; or <input type="file" class="file_seller_notification" style="width: 94px;float:right;"/>';
      }
        $view.='
        <br>
        <div class="btn-save" style="float:left;">
          <button onclick="return ajax_seller_notification(\''.$template_name.'\')" name="simpan_seller_notification" class="btn btn-success">  Save  </button>
        </div>
        <br><br><br>
        <div id="notif_seller_notification'.$template_name.'"></div>
      </div>
    <style>
        #shortcode-reference td{
            font-size:12px;
            padding-left:17px;
        }
    </style>

    '.woowa_shortcode_reference('en').'
    </form>
    </div>'
    ;
    return $view;
}

function woowa_pop_up(){
  $view = 
    '<div class="modal fade addsellernotif" id="addsellernotif" tabindex="-1" role="dialog" aria-labelledby="addsellernotifLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="background: black;">
          <!--<div class="modal-header">
            <h5 class="modal-title" id="addsellernotifLabel">Fill this Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>-->
          <div class="modal-body" style="background: black;">
            <form>
              <div class="form-group">
              <label for="name-form" class="col-form-label">Seller Name</label>
              <input type="text" class="form-control" id="name-form" placeholder="Nama Penjual">
              <label for="whatsapp-form" class="col-form-label">Whatsapp Number</label>
              <input type="text" class="form-control" id="whatsapp-form" placeholder="Nomer Whatsapp">
              <label for="" class="col-form-label">Choose Templates</label><br>
              <input type="checkbox" class="checkAll" name="alllist" value="all_templates"> All Templates<br>
              <hr>
              <input type="checkbox" class="checbox_template_seller" value="after_checkout" name="templateslist[]"> After Checkout<br>
              ';  
                  if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
                    $lotsOfStatus = wc_get_order_statuses();
                  }else {
                    $lotsOfStatus = array();
                  }

                  $lotsOfStatus = wc_get_order_statuses();
                  foreach ($lotsOfStatus as $key => $value) {
                    $statuses = str_replace("wc-", "", $key);
                    $status_name = str_replace("-", "_", $statuses);
                    $view.=' <input type="checkbox" class="checbox_template_seller" value="'.$status_name.'" name="templateslist[]"> '.$value.'<br>';
                  }          
        $view.='
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="return ajax_add_new_seller();" data-dismiss="modal">Add Form</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="deletesellernotif" tabindex="-1" role="dialog" aria-labelledby="deletesellernotifLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deletesellernotifLabel">Delete Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="background: black;">
            <form>
              <div class="form-group">
                Are You Sure Delete This Form?
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="button" id="btn-delete-custom-form" class="btn btn-success"  data-dismiss="modal">Yes</button>
          </div>
        </div>
      </div>
    </div>';

  return $view;
}

function update_seller_notif($id='', $name='', $wa_seller='', $selected=''){
  $view = '
  <div class="modal fade" id="updatesellernotif'.$id.'" tabindex="-1" role="dialog" aria-labelledby="updatesellernotifLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        
        <div class="modal-body" style="background: black;">
          <form>
            <div class="form-group">
            <label for="name-form-'.$id.'" class="col-form-label">Seller Name</label>
            <input type="text" class="form-control" id="name-form-'.$id.'" value="'.$name.'" placeholder="Nama Penjual">
            <label for="whatsapp-form-'.$id.'" class="col-form-label">Whatsapp Number</label>
            <input type="text" class="form-control" id="whatsapp-form-'.$id.'" value="'.$wa_seller.'" placeholder="Nomer Whatsapp Penjual">
            <label for="" class="col-form-label">Choose Templates</label><br>
            <p>All templates will send to you</p>';
            // woowa_prepre(($selected));
            if (in_array('all', $selected)) {
              $view.='<input type="checkbox" class="checkAll" name="alllist'.$id.'" value="all_templates" checked> All Templates<br>';
            }else {
              $view.='<input type="checkbox" class="checkAll" name="alllist'.$id.'" value="all_templates"> All Templates<br>';
            }
    $view.='<hr>
            <p>Chosen templates will send to you</p>';
              if (in_array('all', $selected)) {
                $view.='<input type="checkbox" class="checbox_template_seller" id="checbox_template_seller'.$id.'" value="after_checkout" name="templateslist'.$id.'[]"> After Checkout<br>';
              }else {
                if (in_array('after_checkout', $selected)) {
                  $view.='<input type="checkbox" class="checbox_template_seller" id="checbox_template_seller'.$id.'" value="after_checkout" name="templateslist'.$id.'[]" checked> After Checkout<br>';
                }else {
                  $view.='<input type="checkbox" class="checbox_template_seller" id="checbox_template_seller'.$id.'" value="after_checkout" name="templateslist'.$id.'[]"> After Checkout<br>';
                }
              }
              
              if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
                $lotsOfStatus = wc_get_order_statuses();
              }else {
                $lotsOfStatus = array();
              }
              
              foreach ($lotsOfStatus as $key => $value) {
                $statuses = str_replace("wc-", "", $key);
                $status_name = str_replace("-", "_", $statuses);
                if (in_array('all', $selected)) {
                  $view .= ' <input type="checkbox" class="checbox_template_seller" id="checbox_template_seller'.$id.'" value="'.$status_name.'" name="templateslist'.$id.'[]"> '.$value.'<br>';
                }else {
                  if (in_array($status_name, $selected)) {
                    $view .= ' <input type="checkbox" class="checbox_template_seller" id="checbox_template_seller'.$id.'" value="'.$status_name.'" name="templateslist'.$id.'[]" checked> '.$value.'<br>';
                  }else {
                    $view .= ' <input type="checkbox" class="checbox_template_seller" id="checbox_template_seller'.$id.'" value="'.$status_name.'" name="templateslist'.$id.'[]"> '.$value.'<br>';
                  }
                }
              }
    $view.='</div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" id="btn-update-custom-form" class="btn btn-success" onclick="return ajax_update_seller_list('.$id.');" data-dismiss="modal">Save</button>
        </div>
      </div>
    </div>
  </div>
  ';

  return $view;
}

