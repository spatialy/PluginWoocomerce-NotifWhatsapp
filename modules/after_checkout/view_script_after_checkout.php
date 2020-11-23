<?php

function woowa_script_after_checkout_view(){
	$script = 
    '<script type="text/javascript">
    	function ajax_after_checkout(){
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : jQuery("#form_after_checkout").serialize(),
			    method : "POST", 
			    success : function( response ){  
					jQuery("#notif_after_checkout").html(response).hide().fadeIn().delay(2000).fadeOut("slow");
				},
			    error : function(error){  }
			  });
			  return false;
    	}

    	jQuery("body").on("change", "#file", function() {
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
                    jQuery("#image").val(response);
                }
            });
        });

        jQuery(document).ready(function($){
			$("#onoff_after_checkout").parent().click(function() {   
        		if($(this).hasClass("off")){
        			jQuery("#form_after_checkout").show();
        			jQuery.ajax({
        				url : "'.site_url().'/wp-admin/admin-ajax.php",
					    data : "data=checked&action=onoff_after_checkout",
					    method : "POST",
        				});
        		}else{
        			jQuery("#form_after_checkout").hide();
        			jQuery.ajax({
        				url : "'.site_url().'/wp-admin/admin-ajax.php",
					    data : "data=&action=onoff_after_checkout",
					    method : "POST", 
					});
        		}		
			});

			jQuery("textarea.template-wa").emojioneArea({
				search: false,
				pickerPosition: "right"
			});
		});


    </script>';

    return $script;
}