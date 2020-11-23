<?php 

function woowa_script_cancel_order_view(){

	$script = 
	'<script type="text/javascript">
      function ajax_cancel_order(){
        jQuery.ajax({
          url : "'.site_url().'/wp-admin/admin-ajax.php",
          data : jQuery("#form_cancel_order").serialize(),
          method : "POST", 
          success : function( response ){ jQuery("#notif_cancel_order").html(response).hide().fadeIn().delay(3000).fadeOut("slow");},
          error : function(error){  }
        });
        return false;
      }

        jQuery("body").on("change", "#file_cancel_order", function() {
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
                    jQuery("#image_cancel_order").val(response);
                }
            });
        });

        jQuery(document).ready(function($){
          $("#onoff_cancel_order").parent().click(function() {   
            if($(this).hasClass("off")){
              jQuery("#form_cancel_order").show();
              jQuery.ajax({
                url : "'.site_url().'/wp-admin/admin-ajax.php",
                data : "data=checked&action=onoff_cancel_order",
                method : "POST",
              });
            }else{
              jQuery("#form_cancel_order").hide();
              jQuery.ajax({
                url : "'.site_url().'/wp-admin/admin-ajax.php",
                data : "data=&action=onoff_cancel_order",
                method : "POST", 
            });
          } 
          });
        });


    </script>';

    return $script;
}

?>