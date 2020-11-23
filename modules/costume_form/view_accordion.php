<?php

function woowa_custom_form_accordion_view($title, $id=''){
    $title_id = str_replace(' ', '_', $title);
    $toggle_custom_form = get_option('woowa_toggle_custom_form');

    $view = 
    '<link rel="stylesheet" href="' . site_url() . '/wp-content/plugins/pelanggan/public/css/bootstrap-toggle.min.css">
    <div class="panel panel-default" style="margin-top:5px;">
        <div class="panel-heading">
            <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#custom_form_accordion'.$id.'" value="dinamic" style="display:block;" >'. $title .'</a>
            <div class="on_off_container">
                <input type="checkbox" '.$toggle_custom_form.' data-size="mini" data-toggle="toggle" name="onoff_custom_form" class="onoff_custom_form" data-off="OFF" data-on="ON" data-onstyle="success"  data-offstyle="danger">
                <button class="btn btn-xs btn-primary" style="margin-left:10px; margin-bottom:2px;" data-toggle="modal" data-target="#updatecustomform" onclick="pop_up_custom_form('. $id .')"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-xs btn-danger" style="margin-left:10px; margin-bottom:2px;" data-toggle="modal" data-target="#deletecustomform"><i class="far fa-trash-alt"></i></button>
            </div>
            </h4>
        </div>
        <div id="custom_form_accordion'. $title_id .'" class="panel-collapse collapse ">
            <div class="panel-body">
            '.woowa_custom_form_view($id).'
            </div>
        </div>
    </div>
    
    ';

    return $view;
}