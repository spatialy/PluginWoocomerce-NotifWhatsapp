<?php

function woowa_cs_rotator_view(){
    // woowa_get_data_cs_id();
    // die();
    $popup = pop_up_cs_rotator();
    $view = '';
    $checked = get_option('woowa_check_image_cs_rotator');
    $gambar = get_option('woowa_image_cs_rotator');
    if (get_option('woowa_license')!='active') { return ('<br>please activate license code. click <a href="#license"  data-toggle="tab" aria-expanded="true">here</a>');}
        $toggle_cs_rotator = get_option('woowa_toggle_cs_rotator');
        if ($toggle_cs_rotator != 'checked') {
            $hide='style="display:none;"';
        }else{
            $hide='';
        }
        $script = woowa_script_cs_rotator_view();
    // <input type="checkbox" '.$toggle_cs_rotator.'  data-toggle="toggle" name="onoff_cs_rotator" id="onoff_cs_rotator" data-off="OFF" data-on="ON" data-onstyle="success"  data-offstyle="danger">
    // <p>Turn On to send your message</p>
    $view.='
    ';
    if (get_option('woowa_license_type')!='android') {
        $view.='
        <br><br>
        <div id="btn_toggle_cs_rotator">
            <span style="float:center;">
            <p>Turn On to send your message</p>
            <input type="checkbox" '.$toggle_cs_rotator.'  data-toggle="toggle" name="onoff_cs_rotator" id="onoff_cs_rotator" data-off="OFF" data-on="ON" data-onstyle="success"  data-offstyle="danger">
            </span>
            <span style="float:right;">
            </span>
        </div>
        
        <br>
        <form method="post" id="form_cs_rotator" '. $hide .'>
        <div id="content_cs_rotator">
        <div style="float:left;">
        <h3>Template WA Message : </h3>
        <input type="hidden" name="action" value="save_cs_rotator" >
        <textarea class="template-wa" name="pesan_cs_rotator">';
        $view.=get_option('woowa_pesan_cs_rotator');
        $view.='</textarea>
        <br style="clear:both;">
        <br>
        <button class="btn btn-xs btn-success" style="margin-left:10px; margin-bottom:2px;" onclick=jQuery(".cs-whatsapp-name").val(""); onclick=jQuery(".cs-whatsapp-number").val(""); data-toggle="modal" data-target="#add_cs_number" type="button"><i class="fas fa-cog"></i> Add CS Manually</button>
        <button class="btn btn-xs btn-success" style="margin-left:10px; margin-bottom:2px;" onclick="return ajax_get_data_cs()" type="button"><i class="fas fa-sync"></i> Add CS by Sync</button>
        <div>
        <table class="table" style="border:none;">
            <thead>
            <tr>
                <th scope="col">Seller</th>
                <th scope="col">WA Number</th>';
                if (get_option('woowa_license_type')=='android') {
                $view.='<th scope="col">CS ID</th>';
                }
                $view.='<th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="tbody-cs">';

        $array_cs = get_option('woowa_customer_service_data');
        // echo "<pre>". $array_cs ."</pre>";
        $array_cs = json_decode($array_cs,1);
        // woowa_prepre($array_cs);
        if (!empty($array_cs)) {
            if (!empty(get_option('woowa_customer_service_data'))) {
                foreach ($array_cs as $key => $value) {
                    // echo $key;
                    $id = $key;
                    $name = $value['name'];
                    $wa_cs = $value['wa_number'];
                    $player_id = $value['player_id'];
                    $toggle_cs = get_option('woowa_toggle_customer_service'.$id);
                    $view .= '
                    <tr id="cs_'.$id.'">
                        <td class="cs_rotator_name">
                        '.$name.'
                        </td>
                        <td class="cs_rotator_no_wa">
                        <span>'.$wa_cs.'</span>
                        </td>';
                    if (get_option('woowa_license_type')=='android') {
                    $view.='
                        <td class="cs_rotator_player_id">
                        <span>'.$player_id.'</span>
                        </td>
                        ';
                    }
                    $view.='
                        
                        <td data-cs-rotator-id="'.$id.'">
                        <button class="btn btn-xs btn-primary" type="button" style="margin-left:10px; margin-bottom:2px;" data-toggle="modal" data-target="#update_cs_rotator'.$id.'"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-xs btn-danger" type="button" style="margin-left:10px; margin-bottom:2px; margin-right:10px;" data-toggle="modal" data-target="#delete_cs_rotator'.$id.'"><i class="far fa-trash-alt"></i></button>
                        <input type="checkbox" '.$toggle_cs.' id="toggle_cs'.$id.'" data-toggle="toggle" data-size="mini" class="toggle-cs-rotator">
                        </td>
                    </tr>'.
                    pop_up_cs_rotator($id, $name, $wa_cs, $player_id).'';
                }
            }
        }
    
        $view.='
        </tbody>
      </table>
      </div>';
      if (get_option('woowa_license_type') != 'android') {
      // $view.='<input type="checkbox" value="check" name="checkboximage" '. $checked .' class="cbx" >
      //   <span class="fas fa-paperclip"></span> attach picture : 
      //   <input class="imginput" type="text" id="image" name="image" value="'. $gambar .'" placeholder="https://xyz.com/img.jpg" >
      //   &nbsp;&nbsp; or <input type="file" id="file" style="width: 94px;float:right;"/>';
      }
    $view.='
    <br>
		<br>
		  <div class="btn-save" style="float:left;">
        <button onclick="return ajax_cs_rotator()" name="simpan_cs_rotator" class="btn btn-success" >  Save  </button>
	    </div>
	<br><br><br>
	<div id="notif_cs_rotator"></div>
    </div>

    <style>
        #shortcode-reference td{
            font-size:12px;
            padding-left:20px;
        }
    </style>

    '.woowa_shortcode_reference('en').'

    </div>
    </form>';
    }else {
      $view.='
        <br><br>
        <div id="btn_toggle_cs_rotator">
            <span style="float:right;">
                <p>Turn On to send your message via CS</p>
                <input type="checkbox" '.$toggle_cs_rotator.'  data-toggle="toggle" name="onoff_cs_rotator" id="onoff_cs_rotator" data-off="OFF" data-on="ON" data-onstyle="success"  data-offstyle="danger">
            </span>
            <span style="float:right;"></span>
        </div>';
        $dataplayer = get_option('woowa_customer_service_data');
        $dataplayer = json_decode($dataplayer, 1);

        if (get_option('woowa_license_type') == 'android') {
        $view.='
            <div class="form-group select-device">
                <label for="select-device-option">Select Default Device:</label>
                <select class="form-control" id="select-device-option" style="display: inline-block;">';
                if (!empty(get_option('woowa_save_default_device'))) {
                    $player_id = get_option('woowa_save_default_device');
                    $nameCS = getNameByID($dataplayer, $player_id);
                    $view .='<option value="'.$player_id.'">'.$nameCS.'</option>';
                }
                
                foreach ($dataplayer as $key => $value) {
                    $view .='<option value="'.$value['player_id'].'">'.$value['name'].'</option>';
                }
                $view.=
                '</select>
                <button class="btn btn-success btn-sm bulk-abandoned " id="select-device-button" onclick="save_selected_device()" style="display: inline-block;">Save</button>
            </div>
            <small style="color:red;">*Will not affected on toggle status, used by abandoned cart and seller notification</small>
            <div id="notice_selected_device"></div>';
        }

      $view.='<br>
        <br style="clear:both;">
        <br>
        <button class="btn btn-xs btn-success" style="margin-left:10px; margin-bottom:2px;" onclick=jQuery("#cs-whatsapp-name").val(""); onclick=jQuery("#cs-whatsapp-number").val(""); data-toggle="modal" data-target="#add_cs_number" type="button"><i class="fas fa-cog"></i> Add CS Manually</button>
        <button class="btn btn-xs btn-success" style="margin-left:10px; margin-bottom:2px;" onclick="return ajax_get_data_cs()" type="button"><i class="fas fa-sync"></i> Add CS by Sync</button>
        <div>
        <table class="table" style="border:none;">
            <thead>
            <tr>
                <th scope="col">Seller</th>
                <th scope="col">WA Number</th>';
                if (get_option('woowa_license_type')=='android') {
                $view.='<th scope="col">CS ID</th>';
                }
                $view.='<th scope="col">Action</th>
            </tr>
            </thead>
            <tbody class="tbody-cs">';

        $array_cs = get_option('woowa_customer_service_data');
        // echo "<pre>". $array_cs ."</pre>";
        $array_cs = json_decode($array_cs,1);
        // woowa_prepre($array_cs);
        if (!empty($array_cs)) {
            if (!empty(get_option('woowa_customer_service_data'))) {
                foreach ($array_cs as $key => $value) {
                    // echo $key;
                    $id = $key;
                    $name = $value['name'];
                    $wa_cs = $value['wa_number'];
                    $player_id = $value['player_id'];
                    $toggle_cs = get_option('woowa_toggle_customer_service'.$id);
                    $view .= '
                    <tr id="cs_'.$id.'">
                        <td class="cs_rotator_name">
                        '.$name.'
                        </td>
                        <td class="cs_rotator_no_wa">
                        <span>'.$wa_cs.'</span>
                        </td>';
                    if (get_option('woowa_license_type')=='android') {
                    $view.='
                        <td class="cs_rotator_player_id">
                        <span>'.$player_id.'</span>
                        </td>
                        ';
                    }
                    $view.='
                        
                        <td data-cs-rotator-id="'.$id.'">
                        <button class="btn btn-xs btn-primary" type="button" style="margin-left:10px; margin-bottom:2px;" data-toggle="modal" data-target="#update_cs_rotator'.$id.'"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-xs btn-danger" type="button" style="margin-left:10px; margin-bottom:2px; margin-right:10px;" data-toggle="modal" data-target="#delete_cs_rotator'.$id.'"><i class="far fa-trash-alt"></i></button>
                        <input type="checkbox" '.$toggle_cs.' id="toggle_cs'.$id.'" data-toggle="toggle" data-size="mini" class="toggle-cs-rotator">
                        </td>
                    </tr>'.
                    pop_up_cs_rotator($id, $name, $wa_cs, $player_id).'';
                }
            }
        }
        
            $view.='
            </tbody>
        </table>
        </div>
        <br><br>';
    
      if (get_option('woowa_license_type') != 'android') {
        // $view.='
        // <input type="checkbox" id="cbx-image-cs-template" class="cbx" style="display: none;" value="check" name="checkboximage" '. $checked .'>
        // <label for="cbx-image-cs-template" class="check">
        //     <svg width="18px" height="18px" viewBox="0 0 18 18">
        //         <path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
        //         <polyline points="1 9 7 14 15 4"></polyline>
        //     </svg>
        // </label>
        // <span class="fas fa-paperclip"></span> attach picture : 
        // <input class="imginput" type="text" name="image" id="image_cs_rotator" value="'. $gambar .'" placeholder="https://xyz.com/img.jpg" >
        // &nbsp;&nbsp; or <input type="file" id="file_cs_rotator" style="width: 94px;float:right; margin-right:900px;"/>';
        
      }
    }
    
    return $view.$script.$popup;
}


function pop_up_cs_rotator($id='', $name='', $no_wa='', $player_id=''){
  $view = '
    <div class="modal fade" id="add_cs_number" tabindex="-1" role="dialog" aria-labelledby="add_cs_numberLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="add_cs_numberLabel">Please set your customer service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <form>
                    <div class="form-group">
                    <label for="cs-whatsapp-name" class="col-form-label">Customer Service Name:</label>
                    <input type="text" class="form-control" required="required" id="cs-whatsapp-name">
                    <label for="cs-whatsapp-number" class="col-form-label">WhatsApp Number:</label>
                    <input type="text" class="form-control" required="required" id="cs-whatsapp-number">';

                    if (get_option('woowa_license_type')=='android') {
                    $view.=
                    '<label for="cs-player-id" class="col-form-label">CS ID:</label>
                    <input type="text" class="form-control" required="required" id="cs-player-id">';
                    }
                    
            $view.='</div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="return ajax_add_new_customer_service();" data-dismiss="modal">Add</button>
                </div>
            </div>
        </div>
    </div>';

  $view.=
  '<div class="modal fade" id="update_cs_rotator'.$id.'" tabindex="-1" role="dialog" aria-labelledby="update_cs_rotatorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="update_cs_rotatorLabel">Update Customer Service</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="cs-whatsapp-name" class="col-form-label">Customer Service Name:</label>
            <input type="text" class="form-control" required="required" id="cs-whatsapp-name'.$id.'" value="'.$name.'">
            <label for="cs-whatsapp-number" class="col-form-label">WhatsApp Number:</label>
            <input type="text" class="form-control" required="required" id="cs-whatsapp-number'.$id.'" value="'.$no_wa.'">
            <label for="cs-player-id" class="col-form-label">CS ID:</label>
            <input type="text" class="form-control" required="required" id="cs-player-id'.$id.'" value="'.$player_id.'">
          </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="button" id="btn-update-cs-rotator" class="btn btn-success"  data-dismiss="modal" onclick="return ajax_update_cs_rotator('.$id.');">Save</button>
        </div>
      </div>
    </div>
  </div>';

  $view .= 
  '<div class="modal fade" id="delete_cs_rotator'.$id.'" tabindex="-1" role="dialog" aria-labelledby="delete_cs_rotatorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="delete_cs_rotatorLabel">Delete Customer Service</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              Are You Sure Delete This Customer Service?
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="button" id="btn-delete-cs-rotator" class="btn btn-success"  data-dismiss="modal" onclick="return ajax_delete_customer_service('.$id.')">Yes</button>
        </div>
      </div>
    </div>
  </div>';

  return $view;
}