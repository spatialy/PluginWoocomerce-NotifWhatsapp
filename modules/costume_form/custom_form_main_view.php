<?php

function woowa_main_custom_form_view(){
  $toggle_custom_form = get_option('woowa_toggle_custom_form');
  $tab_aktif['template']='';
  if (!empty($_GET['tab'])) {
    $tab_aktif[$_GET['tab']]="active";
  }else{
    $tab_aktif['template']='active';
  }
  $view = '
  <br>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="' . site_url() . '/wp-content/plugins/pelanggan/public/js/bootstrap.min.js"></script>
  <script src="' . site_url() . '/wp-content/plugins/pelanggan/public/js/chart.js"></script>    
  <script src="' . site_url() . '/wp-content/plugins/pelanggan/public/js/bootstrap-toggle.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script type="text/javascript" src="'.site_url().'/wp-content/plugins/pelanggan/public/js/emojionearea.js"></script>
  
  <link rel="stylesheet" type="text/css" href="'.site_url().'/wp-content/plugins/pelanggan/public/css/emojionearea.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" href="' . site_url() . '/wp-content/plugins/pelanggan/public/css/bootstrap-toggle.min.css">
  <link rel="stylesheet" href="' . site_url() . '/wp-content/plugins/pelanggan/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="' . site_url() . '/wp-content/plugins/pelanggan/public/css/woowa.css?v=0.1.21">
  <link rel="stylesheet" href="' . site_url() . '/wp-content/plugins/pelanggan/public/css/varelaround.css">
  <link rel="stylesheet" href="' . site_url() . '/wp-content/plugins/pelanggan/public/css/vertical-tab.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css"  />
  <style>
    .label-nav{
      display:none;
    }
  </style>
  <script type="text/javascript">
    jQuery(function(){
      jQuery(".nav").find("li").on("click",function(){
        jQuery(".label-nav").hide();
        jQuery(this).find("a").find("span").show();
      });

      jQuery(".wp-has-submenu").hover(
        function() {
          jQuery( this ).addClass("opensub");
        }, function() {
          jQuery( this ).removeClass("opensub");
        }
      );
    });
  </script>
  <div>
    <h2>Whatsapp Pelanggan.Net '.get_option('woowa_license_type').' <small>Premium Version '.woowa_get_current_version().'</small>
      <span style="float:right">
          <h5>Join our group</h5><a href="https://www.facebook.com/groups/pelanggannet/" target="__blank"><i class="fab fa-facebook-f"></i></a> || <a href="https://wa.me/62859141490060" target="__blank"><i class="fas fa-phone"></i></a>|| <a href="https://pelanggan.net/" target="__blank"><i class="fas fa-rss-square"></i></a></span>
      </h2>
      
  </div>
  
  <ul class="nav nav-tabs">';
  if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
    $view.='
      <li class="'.$tab_aktif['template'].'"><a style="font-family: Asap" data-toggle="tab" href="#template_woowa" id="template_btn"><span class="label-nav" style="display:inline;">Custom Form</span> <i class="fas fa-scroll"></i> </a></li>
    ';
  }
    $dataplayer = get_option('woowa_customer_service_data');
    $dataplayer = json_decode($dataplayer, 1);
    $view.='
  </ul>
  
  <div class="container">
    <div class="tab-content">
      <div id="template_woowa" class="tab-pane fade in '.$tab_aktif['template'].'"><br><br>';
      if (get_option('woowa_license_type') == 'android') {
        $view.='
        <div class="form-group select-device">
            <label for="select-device-option-customform">Select Device:</label>
            <select class="form-control" id="select-device-option-customform" style="display: inline-block;">';
            if (!empty(get_option('woowa_save_default_device_customform'))) {
                $player_id = get_option('woowa_save_default_device_customform');
                $nameCS = getNameByID($dataplayer, $player_id);
                $view .='<option value="'.$player_id.'">'.$nameCS.'</option>';
            }
            
            foreach ($dataplayer as $key => $value) {
                $view .='<option value="'.$value['player_id'].'">'.$value['name'].'</option>';
            }
            $view.=
            '
            </select><br>
            <button class="btn btn-success btn-sm bulk-abandoned " id="select-device-button-customform" onclick="save_selected_device_cf();" style="display: inline-block;">Save</button>
        </div>
        <div id="notice_selected_device_customform"></div>';
      }
      

  $view.='<div><button class="btn btn-sm btn-primary" style="margin-bottom:10px;" data-toggle="modal" data-target="#addcustomform" onclick=jQuery("#title-form-name").val(""); >Add Custom Form</button></div>';


$view .='<div class="panel-group" id="accordion">';
     
        $arrays_form = get_option('woowa_custom_form_data');
        if (!empty($arrays_form)) {
          $arrays_form = json_decode($arrays_form, 1);
          foreach ($arrays_form as $key => $values) {
            $id = $key;
            $title = $values['title'];
            $toggle_custom_form = get_option('woowa_toggle_custom_form'.$id);
            
            $view.='
            <div class="panel panel-default" id="accordion_'.$id.'">
              <div class="panel-heading">
                <h4 class="panel-title">
                <a data-toggle="collapse" id="custom_form_'. $id .'" data-parent="#accordion" href="#custom_form_accordion'.$id.'" value="dinamic" style="display:block;" >'. $title .' </a>
                <div class="on_off_container" data-custom-form-id="'. $id .'">
                  <input type="checkbox" '.$toggle_custom_form.' data-size="mini" data-toggle="toggle" name="onoff_custom_form'.$id.'" class="onoff_custom_form" data-off="OFF" data-on="ON" data-onstyle="success"  data-offstyle="danger">
                  <button class="btn btn-xs btn-primary" style="margin-left:10px; margin-bottom:2px;" data-toggle="modal" data-target="#updatecustomform" onclick="pop_up_custom_form('. $id .')"><i class="fas fa-pencil-alt"></i></button>
                  <button class="btn btn-xs btn-danger" style="margin-left:10px; margin-bottom:2px;" data-toggle="modal" data-target="#deletecustomform" onclick="pop_up_custom_form('. $id .')"><i class="far fa-trash-alt"></i></button>
                </div>
                </h4>
              </div>
              <div id="custom_form_accordion'.$id.'" class="panel-collapse collapse ">
                  <div class="panel-body">
                  '.woowa_custom_form_view($id).'
                  </div>
              </div>
            </div>';
          }
        }
          $view.='
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="addcustomform" tabindex="-1" role="dialog" aria-labelledby="addcustomformLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addcustomformLabel">Please set the title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="title-form-name" class="col-form-label">Title form:</label>
              <input type="text" class="form-control" required="required" id="title-form-name">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="return ajax_add_new_form();" data-dismiss="modal">Add Form</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="deletecustomform" tabindex="-1" role="dialog" aria-labelledby="deletecustomformLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deletecustomformLabel">Delete Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
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
  </div>

  <div class="modal fade" id="updatecustomform" tabindex="-1" role="dialog" aria-labelledby="updatecustomformLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updatecustomformLabel">Update Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="title-name" class="col-form-label">Title:</label>
              <input type="text" class="custom_form" class="form-control">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" id="btn-update-custom-form" class="btn btn-success"  data-dismiss="modal">Yes</button>
        </div>
      </div>
    </div>
  </div>
  '.
  $script = woowa_script_custom_form_view();

  return $view.$script;


}