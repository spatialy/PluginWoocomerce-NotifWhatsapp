<?php
function woowa_script_custom_form_view(){

	$script = 
	'<script type="text/javascript">
		function ajax_scan_url(id){
			jQuery(".result_scan").html("Please wait...");
			var url=jQuery(".custom_form_url"+id).val();
			jQuery(".url_scan").html(url);
			jQuery(".url_scan").attr("href",url);
			jQuery(".url_scan").attr("title",url);
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : "action=scan_url&url="+url,
			    method : "POST", 
			    success : function( response ){  
					jQuery(".result_scan").html(response);
				},
			    error : function(error){  }
			});
			return false;
		}
		
		function save_selected_device_cf() {
			var data = jQuery("#select-device-option-customform").val();
			jQuery.ajax({
				url: "'.site_url().'/wp-admin/admin-ajax.php",
				data: "data="+data+"&action=save_selected_device_customform",
				method: "POST",
				success: function(response) {
					jQuery("#notice_selected_device_customform").html(response).hide().fadeIn().delay(2000).fadeOut("slow");
				},
				error: function(error) {}
			});
		}

    	function ajax_custom_form(custom_form_id){
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : jQuery("#form_custom_form"+custom_form_id).serialize(),
			    method : "POST",
			    success : function( response ){  jQuery("#notif_custom_form"+custom_form_id).html(response).hide().fadeIn().delay(2000).fadeOut("slow");},
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
                    jQuery(".image_custom_form").val(response);
                }
            });
        });

        jQuery(document).ready(function($){
			$(".onoff_custom_form").parent().on("click",function() {
				var custom_form_id = $(this).parent().attr("data-custom-form-id");
        		if($(this).hasClass("off")){
        			jQuery("#form_custom_form"+custom_form_id).show();
        			jQuery.ajax({
						url : "'.site_url().'/wp-admin/admin-ajax.php",
						data : "data=checked&custom_form_id="+custom_form_id+"&action=onoff_custom_form",
						method : "POST",
					});
        		}else{
        			jQuery("#form_custom_form"+custom_form_id).hide();
        			jQuery.ajax({
        				url : "'.site_url().'/wp-admin/admin-ajax.php",
					    data : "data=&custom_form_id="+custom_form_id+"&action=onoff_custom_form",
					    method : "POST", 
					});
        		}		
			});

			jQuery("textarea.template-wa").emojioneArea({
				search: false,
				pickerPosition: "right"
			});
		});

		function ajax_add_new_form(){
			var title = jQuery("#title-form-name").val();
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : "title="+title+"&action=save_new_title_form",
			    method : "POST",
				success : function( response ){
					//jQuery("#accordion").append( response );
					location.reload();
				},
			    error : function(error){  }
			});

			return false;
		}
		
		function ajax_delete_custom_form(id){
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : "id="+id+"&action=delete_custom_form",
			    method : "POST",
				success :
					jQuery("#accordion_"+id).remove(),
			    error : function(error){  }
			});

			return false;
		}

		function pop_up_custom_form(id){
			jQuery("#btn-delete-custom-form").attr("onclick", "return ajax_delete_custom_form("+id+");");
			jQuery("#btn-update-custom-form").attr("onclick", "return update_custom_form("+id+");");
		}

		function update_custom_form(id){
			var title = jQuery(".custom_form").val();
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : "id="+id+"&title="+title+"&action=update_custom_form",
			    method : "POST",
				success : function (r){	
						jQuery("#custom_form_"+id).html(r);
					},
			    error : function(error){  }
			});

			return false;
		}

    </script>';

    return $script;

}