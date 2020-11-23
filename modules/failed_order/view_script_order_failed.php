<?php

function woowa_script_order_failed_view(){
	$script = 
    '<script type="text/javascript">
    	function ajax_order_failed(){
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : jQuery("#form_order_failed").serialize(),
			    method : "POST", 
			    success : function( response ){  jQuery("#notif_order_failed").html(response).hide().fadeIn().delay(2000).fadeOut("slow");},
			    error : function(error){  }
			  });
			  return false;
    	}

    	jQuery("body").on("change", "#file_failed", function() {
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
                    jQuery("#image_order_failed").val(response);
                }
            });
        });

        jQuery(document).ready(function($){
			$("#onoff_order_failed").parent().click(function() {   
        		if($(this).hasClass("off")){
        			jQuery("#form_order_failed").show();
        			jQuery.ajax({
        				url : "'.site_url().'/wp-admin/admin-ajax.php",
					    data : "data=checked&action=onoff_order_failed",
					    method : "POST",
        				});
        		}else{
        			jQuery("#form_order_failed").hide();
        			jQuery.ajax({
        				url : "'.site_url().'/wp-admin/admin-ajax.php",
					    data : "data=&action=onoff_order_failed",
					    method : "POST",
					});
        		}		
			});
		});


    </script>';

    return $script;
}