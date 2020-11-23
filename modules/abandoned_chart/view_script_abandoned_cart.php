<?php

function woowa_script_abandoned_cart_view()
{
    $script =
    '<script type="text/javascript">
    	function ajax_abandoned_cart(){
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : jQuery("#form_abandoned_cart").serialize(),
			    method : "POST", 
			    success : function( response ){  jQuery("#notif_abandoned_cart").html(response).hide().fadeIn().delay(2000).fadeOut("slow");},
			    error : function(error){  }
			  });
			  return false;
    	}

		function ajax_send_wa_abandoned(id) {
			jQuery("#woowa-span"+id).html(" Sending message!");
			jQuery.ajax({
				url: "'.site_url().'/wp-admin/admin-ajax.php",
				data: "id="+id+"&action=send_wa_abandoned",
				method: "POST",
				success: function(response) {
					jQuery("#woowa-span"+id).html(" Message sent").hide().fadeIn().delay(2000).fadeOut("slow");
				},
				error: function(error) {}
			});
		}
		
		function save_selected_device() {
			var data = jQuery("#select-device-option").val();
			jQuery.ajax({
				url: "'.site_url().'/wp-admin/admin-ajax.php",
				data: "data="+data+"&action=save_selected_device",
				method: "POST",
				success: function(response) {
					jQuery("#notice_selected_device").html(response).hide().fadeIn().delay(2000).fadeOut("slow");
				},
				error: function(error) {}
			});
		}

		// jQuery(\'#sel1\').on(\'change\', function () {
		// 	var data = jQuery(this).find(\':selected\')[0].id;
		// 	console.log(data);
		// 	console.log("ikeh");
		// 	jQuery.ajax({
		// 		url: "'.site_url().'/wp-admin/admin-ajax.php",
		// 		data: "data="+data+"&action=save_selected_device",
		// 		method: "POST",
		// 		success: function(response) {
		// 			jQuery(".notice_selected_device").html("Saved").hide().fadeIn().delay(2000).fadeOut("slow");
		// 		},
		// 		error: function(error) {}
		// 	});
		// });
		
		function ajax_bulk_abandoned(){
			function send_message() {     
				jQuery(".resend_message").click(); 
				return false;
			}
			
			setTimeout(send_message, 2000);
			  
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
                    jQuery("#image_abandoned_cart").val(response);
                }
            });
        });

        jQuery(document).ready(function($){
			$("#onoff_abandoned_cart").parent().click(function() {   
        		if($(this).hasClass("off")){
        			jQuery("#form_abandoned_cart").show();
        			jQuery.ajax({
        				url : "'.site_url().'/wp-admin/admin-ajax.php",
					    data : "data=checked&action=onoff_abandoned_cart",
					    method : "POST",
					});
        		}else{
        			jQuery("#form_abandoned_cart").hide();
        			jQuery.ajax({
        				url : "'.site_url().'/wp-admin/admin-ajax.php",
					    data : "data=&action=onoff_abandoned_cart",
					    method : "POST",
					});
        		}		
			});
		});
		
		jQuery(document).ready(function () {
			jQuery( "#checkAllaban" ).click( function () {
				jQuery( ".check_abandoned" ).prop("checked", this.checked)
			})

			jQuery("input[type=checkbox]").click(function(){
				var centang=jQuery(this).prop("checked");
				if(centang==true){
					jQuery(this).parent().parent().find(".abandoned_table").find(".btn-success").addClass("abandoned");
				}else{
					jQuery(this).parent().parent().find(".abandoned_table").find(".btn-success").removeClass("abandoned");
				}
			});

			jQuery("#checkAllaban").click(function(){
				var centang=jQuery(this).prop("checked");
				if(centang==true){
					jQuery("tbody").find(".abandoned_table").find(".btn-success").addClass("abandoned");
				}else{
					jQuery("tbody").find(".abandoned_table").find(".btn-success").removeClass("abandoned");
				}
			});
		});

		

    </script>';

    return $script;
}
