<?php

function woowa_script_pending_payment_view(){
	$script = 
    '<script type="text/javascript">
    	function ajax_pending_payment(){
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : jQuery("#form_pending_payment").serialize(),
			    method : "POST", 
			    success : function( response ){  jQuery("#notif_pending_payment").html(response).hide().fadeIn().delay(2000).fadeOut("slow");},
			    error : function(error){  }
			  });
			  return false;
    	}

    	jQuery("body").on("change", "#file_pending", function() {
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
                    jQuery("#image_pending_payment").val(response);
                }
            });
        });

        jQuery(document).ready(function($){
			$("#onoff_pending_payment").parent().click(function() {   
        		if($(this).hasClass("off")){
        			jQuery("#form_pending_payment").show();
        			jQuery.ajax({
        				url : "'.site_url().'/wp-admin/admin-ajax.php",
					    data : "data=checked&action=onoff_pending_payment",
					    method : "POST",
					});
        		}else{
        			jQuery("#form_pending_payment").hide();
        			jQuery.ajax({
        				url : "'.site_url().'/wp-admin/admin-ajax.php",
					    data : "data=&action=onoff_pending_payment",
					    method : "POST",
					});
        		}		
			});
		});

		// jQuery("textarea.template-wa").emojioneArea({
		// 	pickerPosition: "bottom",
		// 	tones: false,
		// 	search: false
		// });
		
    </script>';

    return $script;
}