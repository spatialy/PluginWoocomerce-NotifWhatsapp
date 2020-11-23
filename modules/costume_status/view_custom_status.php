<?php

function woowa_custom_status_template_view($custom_status_id, $slug_custom_status=''){
    if (get_option('woowa_license')!='active') { return ('<br>please activate license code. click <a href="#license"  data-toggle="tab" aria-expanded="true">here</a>');}
	$view='';
    $toggle_custom_status = get_option('woowa_toggle_custom_status'.$slug_custom_status);
    $gambar = get_option('woowa_image_custom_status'.$slug_custom_status);
    $checked = get_option('woowa_check_custom_status'.$slug_custom_status);
    
    // if ($toggle_custom_status == '') {
    // 	$hide='style="display:none;"';
    // }else{
    	$hide='';
    // }
    $view.='
    <form method="post" id="form_custom_status'.$custom_status_id.'" '. $hide .'>
    <input type="hidden" name="slug_custom_status'.'" class="slug_custom_status" value="'. $slug_custom_status .'">
    <input type="hidden" name="custom_status_id" class="custom_status_id" value="'. $custom_status_id .'">
    <div id="content_custom_status'.$custom_status_id.'">
    <div style="float:left;">

    <h3>Template WA Message : </h3>
    <input type="hidden" name="action" value="save_custom_status" >
    <textarea class="template-wa" name="pesan_custom_status'.$slug_custom_status.'">';
    $view.=get_option('woowa_pesan_custom_status'.$slug_custom_status);
    $view.='</textarea>
        <br style="clear:both;">';
    if (get_option('woowa_license_type') != 'android') {
        // $view.='<input type="checkbox" value="check" name="checkboximage" '. $checked .' class="cbx" >
        // <span class="fas fa-paperclip"></span> attach picture : 
        // <input type="text" name="image" class="image_custom_status" value="'. $gambar .'" placeholder="https://xyz.com/img.jpg" >
        // &nbsp;&nbsp; or  <input type="file" id="file_custom_status" class="file_custom_status" style="width: 94px;float:right;"/>';
    }
      $view.='
      <br>
      <div class="btn-save" style="float:left;">
        <button onclick="return ajax_custom_status('.$custom_status_id.')" name="simpan_custom_status" class="btn btn-success">  Save  </button>
      </div>
      <br><br><br>
      <div id="notif_custom_status'.$custom_status_id.'"></div>
      
        
    </div>

    <style>
        #shortcode-reference td{
            font-size:12px;
            padding-left:20px;
        }
    </style>

    '.woowa_shortcode_reference('en').'
    </form>
    </div>';
    return $view;
}

function woowa_custom_status_accordion(){
    $script = woowa_script_custom_status_view();
    $view =
    '<div><button class="btn btn-sm btn-primary" style="margin-bottom:10px;" data-toggle="modal" data-target="#addcustomstatus" >Add Template</button></div>
    <div class="panel-group" id="accordion_custom_status">';
    // TODO: looping view
    $arrays_status = get_option('woowa_custom_status_data');
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
        $array = wc_get_order_statuses();
    }else {
        $array = $array();
    }
    $modal = woowa_modal_customstatus($array);
    if (!empty($arrays_status)) {
        $arrays_status = json_decode($arrays_status, 1);
        foreach ($arrays_status as $key => $values) {
            // echo $key;
        $id = $key;
        $title = ($values['title']);
        $slug = $values['slug'];
        $toggle_custom_status = get_option('woowa_toggle_custom_status'.$slug);
        
        $view.='
            <div class="panel panel-default" id="accordion_'.$id.'">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" id="custom_status_'. $id .'" data-parent="#accordion" href="#custom_status_accordion'.$id.'" value="dinamic" style="display:block;" >'. $title .' </a>
                    <div class="on_off_container" data-custom-status-id="'. $slug .'">
                        <input type="checkbox" '.$toggle_custom_status.' data-size="mini" data-toggle="toggle" name="onoff_custom_status'.$id.'" class="onoff_custom_status" data-off="OFF" data-on="ON" data-onstyle="success"  data-offstyle="danger">
                        <button class="btn btn-xs btn-danger" style="margin-left:10px; margin-bottom:2px;" data-toggle="modal" data-target="#deletecustomstatus" onclick="pop_up_custom_status('. $id .')"><i class="far fa-trash-alt"></i></button>
                    </div>
                    </h4>
                </div>
                <div id="custom_status_accordion'.$id.'" class="panel-collapse collapse ">
                    <div class="panel-body">
                    '.woowa_custom_status_template_view($id, $values['slug']).'
                    </div>
                </div>
            </div>
            ';
        }
    }else {

    }
        $view.='
        </div>
      ';

    return $view.$script.$modal;
}

function woowa_modal_customstatus($array){
    $view ='
        <div class="modal fade" id="addcustomstatus" tabindex="-1" role="dialog" aria-labelledby="addcustomstatusLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addcustomstatusLabel">Please pick the status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                        <div class="form-group">
                            <label for="title-custom-status">Custom Status</label>
                            <select class="form-control" id="title-custom-status">';

                            $i=1;
                            foreach ($array as $key => $value) {
                                if( $i++ < 8){
                                    continue;
                                }
                                $view.= '<option>'.$value.'</option>';
                            }
                    $view.='</select>
                        </div>
                        </form>
                        <small style="color:red">*Make sure your status has slug</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="return ajax_add_new_status();" data-dismiss="modal">Add status</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="deletecustomstatus" tabindex="-1" role="dialog" aria-labelledby="deletecustomstatusLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletecustomstatusLabel">Delete status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="status-group">
                                Are You Sure Delete This status?
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" id="btn-delete-custom-status" class="btn btn-success"  data-dismiss="modal">Yes</button>
                    </div>
                </div>
            </div>
        </div>';

return $view;
}

function woowa_custom_status_accordion_view($title, $id='', $slug=''){
    $title_id = str_replace(' ', '_', $title);
    $toggle_custom_status = get_option('woowa_toggle_custom_status'.$slug);

    $view = 
    '
    <link rel="stylesheet" href="' . site_url() . '/wp-content/plugins/pelanggan/public/css/bootstrap-toggle.min.css">
    <div class="panel panel-default" style="margin-top:5px;">
        <div class="panel-heading">
            <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion_custom_status" href="#custom_status_accordion'.$id.'" value="dinamic" style="display:block;" >'. $title .'</a>
            <div class="on_off_container">
                <input type="checkbox" '.$toggle_custom_status.' data-size="mini" data-toggle="toggle" name="onoff_custom_status" class="onoff_custom_status" data-off="OFF" data-on="ON" data-onstyle="success"  data-offstyle="danger">
                <button class="btn btn-xs btn-primary" style="margin-left:10px; margin-bottom:2px;" data-toggle="modal" data-target="#updatecustomstatus" onclick="pop_up_custom_status('. $id .')"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-xs btn-danger" style="margin-left:10px; margin-bottom:2px;" data-toggle="modal" data-target="#deletecustomstatus"><i class="far fa-trash-alt"></i></button>
            </div>
            </h4>
        </div>
        <div id="custom_status_accordion'. $title_id .'" class="panel-collapse collapse ">
            <div class="panel-body">
            '.woowa_custom_status_template_view($id, $slug).'
            </div>
        </div>
    </div>
    
    ';

    return $view;
}