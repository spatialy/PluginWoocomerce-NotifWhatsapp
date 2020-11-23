<?php

function woowa_script_reminder_order_view(){
  $script =
    '<script type="text/javascript">
      function cek_diff_template(that){
        if(jQuery(that).prop("checked")==true){
          jQuery(\'#div_diff_templates\').show();
        }else{
          jQuery(\'#div_diff_templates\').hide();
        }
        
      }

      function ajax_reminder_order(){
        jQuery.ajax({
          url : "'.site_url().'/wp-admin/admin-ajax.php",
          data : jQuery("#form_reminder_order").serialize(),
          method : "POST", 
          success : function( response ){
            jQuery("#notif_reminder_order").html(response).hide().fadeIn().delay(3000).fadeOut("slow");
          },
          error : function(error){  }
        });
        return false;
      }

      jQuery("body").on("change", "#file_reminder_order", function() {
        var file_data = jQuery(this).prop(\'files\')[0];
        var form_data = new FormData();
        form_data.append(\'file\', file_data);
        form_data.append(\'action\', \'file_upload\');
        jQuery.ajax({
          url : "'.site_url().'/wp-admin/admin-ajax.php",
          type: "POST",
          contentType: false,
          processData: false,
          data: form_data,
          success: function (response) {
            jQuery("#image_reminder_order").val(response);
          }
        });
      });

      jQuery(document).ready(function($){ 
      $(\'#btntogglereminder\').click(function() {   
          $(\'#content_reminder_order\').toggle(\'slow\');
        });
      });

      jQuery(document).ready(function($){
        $("#onoff_reminder_order").parent().click(function() {   
          if($(this).hasClass("off")){
            jQuery("#form_reminder_order").show();
            jQuery.ajax({
              url : "'.site_url().'/wp-admin/admin-ajax.php",
              data : "data=checked&action=onoff_reminder_order",
              method : "POST",
            });
          }else{
            jQuery("#form_reminder_order").hide();
            jQuery.ajax({
              url : "'.site_url().'/wp-admin/admin-ajax.php",
              data : "data=&action=onoff_reminder_order",
              method : "POST",
          });
        } 
      });

      jQuery(".template-wa-reminder").emojioneArea({
				search: false,
				pickerPosition: "right"
      });
      
    });

    function ajax_reminder_message(that,ke){
      jQuery(".reminder-btn").removeClass("reminder-btn-active");
      jQuery(that).addClass("reminder-btn-active");
      jQuery("#ke").val(ke);
      jQuery(".loading-reminder-message").html("<img src=\''.plugins_url( '../../public/img/tenor.gif', __FILE__ ) .'\' style=\'width: 30px;margin-top:-10px;\'>");
      var tipe = ke;
      jQuery.ajax({
        url : "'.site_url().'/wp-admin/admin-ajax.php",
        dataType : "json",
        data : "data="+tipe+"&action=reminder_message",
        method : "POST", 
        success : function( response ){
          jQuery(".template-wa-reminder").data("emojioneArea").setText(response.pesan);
          jQuery( "#image_reminder_order" ).val( response.gambar );
          if(response.checkbox == ""){
            jQuery( "#cek_img_reminder" ).prop(\'checked\', false);
          }else {
            jQuery( "#cek_img_reminder" ).prop(\'checked\', true);
          }
          jQuery(".loading-reminder-message").html("");
        },
        error : function(error){  }
      });
      return false;
    }

    function ajax_reminder_accordion(t){
      var targetID = t;
      jQuery.ajax({
        url: "'.site_url().'/wp-admin/admin-ajax.php",
        method: \'POST\',
        data: "data="+targetID+"&action=reminder_accordion",
        success : function( response ){
        },
        error : function (error){}
      });
      return false;
    }

    </script>';

    return $script;
}

?>