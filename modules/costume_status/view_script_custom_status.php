<?php

function woowa_script_custom_status_view(){
	$script = 
    '<script type="text/javascript">
    	function ajax_custom_status(custom_status_id){
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : jQuery("#form_custom_status"+custom_status_id).serialize(),
			    method : "POST", 
			    success : function( response ){  jQuery("#notif_custom_status"+custom_status_id).html(response).hide().fadeIn().delay(2000).fadeOut("slow");},
			    error : function(error){  }
			  });
			  return false;
    	}

    	jQuery("body").on("change", ".file_custom_status", function() {
            var file_data = jQuery(this).prop(\'files\')[0];
            var form_data = new FormData();
            form_data.append(\'file\', file_data);
			form_data.append(\'action\', \'file_upload\');
			var form_id = jQuery(this).parent().parent().parent().attr("id");

            jQuery.ajax({
                url : "'.site_url().'/wp-admin/admin-ajax.php",
                type: "POST",
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    jQuery("#"+form_id+" .image_custom_status").val(response);
                }
            });
        });

        jQuery(document).ready(function($){
			$(".onoff_custom_status").parent().on("click",function() {
				var custom_status_id = $(this).parent().attr("data-custom-status-id");
        		if($(this).hasClass("off")){
        			jQuery("#form_custom_status"+custom_status_id).show();
        			jQuery.ajax({
                        url : "'.site_url().'/wp-admin/admin-ajax.php",
                        data : "data=checked&custom_status_id="+custom_status_id+"&action=onoff_custom_status",
                        method : "POST",
					});
        		}else{
        			jQuery("#form_custom_status"+custom_status_id).hide();
        			jQuery.ajax({
        				url : "'.site_url().'/wp-admin/admin-ajax.php",
					    data : "data=&custom_status_id="+custom_status_id+"&action=onoff_custom_status",
					    method : "POST", 
					});
        		}		
			});
		});

        function ajax_add_new_status(){
			var title = jQuery("#title-custom-status").val();
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : "title="+title+"&action=add_custom_status",
			    method : "POST",
				success : function( response ){
					//jQuery("#accordion").append( response );
					location.reload();
				},
			    error : function(error){  }
			});

			return false;
		}
		
		function ajax_delete_custom_status(id){
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : "id="+id+"&action=delete_custom_status",
			    method : "POST",
				success :
					jQuery("#accordion_"+id).remove(),
			    error : function(error){  }
			});

			return false;
		}

		function pop_up_custom_status(id){
			jQuery("#btn-delete-custom-status").attr("onclick", "return ajax_delete_custom_status("+id+");");
			jQuery("#btn-update-custom-status").attr("onclick", "return update_custom_status("+id+");");
		}

		function update_custom_status(id){
			var title = jQuery(".custom_status").val();
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : "id="+id+"&title="+title+"&action=update_custom_status",
			    method : "POST",
				success : function (r){	
						jQuery("#custom_status_"+id).html(r);
					},
			    error : function(error){  }
			});

			return false;
		}

    </script>';

    return $script;
}