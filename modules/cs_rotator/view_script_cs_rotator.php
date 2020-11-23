<?php 

function woowa_script_cs_rotator_view(){

	$script = 
	'<script type="text/javascript">
      function ajax_cs_rotator(){
        jQuery.ajax({
          url : "'.site_url().'/wp-admin/admin-ajax.php",
          data : jQuery("#form_cs_rotator").serialize(),
          method : "POST", 
          success : function( response ){ jQuery("#notif_cs_rotator").html(response).hide().fadeIn().delay(3000).fadeOut("slow");},
          error : function(error){  }
        });
        return false;
      }

        jQuery("body").on("change", "#file_cs_rotator", function() {
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
                    jQuery("#image_cs_rotator").val(response);
                }
            });
        });

        jQuery(document).ready(function($){
          $("#onoff_cs_rotator").parent().click(function() {   
            if($(this).hasClass("off")){
              jQuery("#form_cs_rotator").show();
              jQuery.ajax({
                url : "'.site_url().'/wp-admin/admin-ajax.php",
                data : "data=checked&action=onoff_cs_rotator",
                method : "POST",
              });
            }else{
              jQuery("#form_cs_rotator").hide();
              jQuery.ajax({
                url : "'.site_url().'/wp-admin/admin-ajax.php",
                data : "data=&action=onoff_cs_rotator",
                method : "POST", 
            });
            } 
          });
        });

    function ajax_add_new_customer_service(){
			var name = jQuery("#cs-whatsapp-name").val();
			var player_id = jQuery("#cs-player-id").val();
			var wa_number = jQuery("#cs-whatsapp-number").val();
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : "player_id="+player_id+"&wa_number="+wa_number+"&name="+name+"&action=save_new_customer_service",
			    method : "POST",
          success : function( response ){
					// jQuery(".tbody-cs").append( response );
          window.location.replace("admin.php?page=woo-wa-premium&tab=cs_rotator");
				},
			    error : function(error){  }
			});
			return false;
		}
    
    function ajax_update_cs_rotator(id){
      var player_id = jQuery("#cs-player-id"+id).val();
      var name = jQuery("#cs-whatsapp-name"+id).val();
			var wa_number = jQuery("#cs-whatsapp-number"+id).val();
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : "id="+id+"&player_id="+player_id+"&wa_number="+wa_number+"&name="+name+"&action=update_customer_service",
			    method : "POST",
          success : function (r){	
						jQuery("#cs_"+id+" .cs_rotator_name").html(name);
            jQuery("#cs_"+id+" .cs_rotator_no_wa").html(wa_number);
            jQuery("#cs_"+id+" .cs_rotator_player_id").html(player_id);
					},
			    error : function(error){  }
			});
			return false;
    }
    
    function ajax_delete_customer_service(id){
      jQuery.ajax({
        url : "'.site_url().'/wp-admin/admin-ajax.php",
        data : "id="+id+"&action=delete_customer_service",
        method : "POST",
        success : function(){
          jQuery("#cs_"+id).remove();
          // var jml=jQuery(".tbody-cs tr").length;
          // for(var i=0;i<jml;i++){
          //   jQuery(".tbody-cs tr").eq(i).removeAttr("id").attr("id","cs_"+(i+1));
          // }
        },
        error : function(error){  }
			});
			return false;
    }
    
    function ajax_get_data_cs(){
      jQuery.ajax({
        url : "'.site_url().'/wp-admin/admin-ajax.php",
        data : "data=&action=get_data_cs",
        method : "POST",
        success : function( response ){
          window.location.replace("admin.php?page=woo-wa-premium&tab=cs_rotator");
				},
        error : function(error){}
			});
			return false;
		}

    jQuery(document).ready(function($){
			$(".toggle-cs-rotator").parent().on("click",function() {
				var cs_rotator_id = $(this).parent().attr("data-cs-rotator-id");
          if($(this).hasClass("off")){
            jQuery.ajax({
              url : "'.site_url().'/wp-admin/admin-ajax.php",
              data : "data=checked&cs_rotator_id="+cs_rotator_id+"&action=onoff_customer_service",
              method : "POST",
            });
          }else{
            jQuery.ajax({
              url : "'.site_url().'/wp-admin/admin-ajax.php",
              data : "data=&cs_rotator_id="+cs_rotator_id+"&action=onoff_customer_service",
              method : "POST",
          });
        }
			});
		});

    </script>';

    return $script;
}

?>