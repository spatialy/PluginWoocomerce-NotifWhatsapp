<?php 

function woowa_script_order_complete_view(){
	$script = 
	'<script type="text/javascript">
      function ajax_order_complete(){
        jQuery.ajax({
          url : "'.site_url().'/wp-admin/admin-ajax.php",
          data : jQuery("#form_order_complete").serialize(),
          method : "POST", 
          success : function( response ){ jQuery("#notif_order_complete").html(response).hide().fadeIn().delay(3000).fadeOut("slow");},
          error : function(error){  }
        });
        return false;
      }

        jQuery("body").on("change", "#file_order_complete", function() {
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
                    jQuery("#image_order_complete").val(response);
                }
            });
        });

        jQuery(document).ready(function($){
          $("#onoff_order_complete").parent().click(function() {   
            if($(this).hasClass("off")){
              jQuery("#form_order_complete").show();
              jQuery.ajax({
                url : "'.site_url().'/wp-admin/admin-ajax.php",
                data : "data=checked&action=onoff_order_complete",
                method : "POST",
              });
            }else{
              jQuery("#form_order_complete").hide();
              jQuery.ajax({
                url : "'.site_url().'/wp-admin/admin-ajax.php",
                data : "data=&action=onoff_order_complete",
                method : "POST",
            });
          } 
      });
    });

    function ajax_order_completed_message(that, ke_order_completed){
      jQuery(".order-completed-btn").removeClass("order-completed-btn-active");
      jQuery(that).addClass("order-completed-btn-active");
      jQuery("#ke_order_completed").val(ke_order_completed);
      jQuery(".loading-order-completed-message").html("<img src=\''.plugins_url( '../../public/img/tenor.gif', __FILE__ ) .'\' style=\'width: 30px;margin-top:-10px;\'>");
      var tipe = ke_order_completed;
      jQuery.ajax({
        url : "'.site_url().'/wp-admin/admin-ajax.php",
        dataType : "json",
        data : "data="+tipe+"&action=order_completed_message",
        method : "POST", 
        success : function( response ){
          jQuery( ".template-wa-order_completed" ).data("emojioneArea").setText(response.pesan);
          jQuery( "#image_order_complete" ).val( response.gambar );
          if(response.checkbox == ""){
            jQuery( "#cek_img_order_completed" ).prop(\'checked\', false);
          }else {
            jQuery( "#cek_img_order_completed" ).prop(\'checked\', true);
          }
          jQuery(".loading-order-completed-message").html("");
        },
        error : function(error){  }
      });
      return false;
    }

    
    

  </script>';

  return $script;
}