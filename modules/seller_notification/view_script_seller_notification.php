<?php 

function woowa_script_seller_notification_view(){

	$script = 
	'<script type="text/javascript">
      function ajax_seller_notification(template_name){
        jQuery.ajax({
          url : "'.site_url().'/wp-admin/admin-ajax.php",
          data : jQuery("#form_seller_notification"+template_name).serialize()+"&tipe="+template_name,
          method : "POST", 
          success : function( response ){ jQuery("#notif_seller_notification"+template_name).html(response).hide().fadeIn().delay(3000).fadeOut("slow");},
          error : function(error){  }
        });
        return false;
      }

      // $("#foo").on("change",function(){
      //   var dataid = $("#foo option:selected").attr("data-id");
      //   ajax_seller_message(dataid);
      // });

      // function ajax_seller_message(dataid){
      //   var tipe = dataid;
      //   jQuery("#tipe").val(dataid);
      //   jQuery.ajax({
      //     url : "'.site_url().'/wp-admin/admin-ajax.php",
      //     dataType : "json",
      //     data : "tipe="+tipe+"&action=seller_message",
      //     method : "POST", 
      //     success : function( response ){
      //       jQuery( ".template-wa-seller" ).val( response.pesan );
      //       // jQuery( "#image_seller_order" ).val( response.gambar );
      //     },
      //     error : function(error){  }
      //   });
      //   return false;
      // }

      
      jQuery("body").on("change", ".file_seller_notification", function() {
          var form_id = jQuery(this).parent().parent().parent().attr("id");
          var file_data = jQuery(this).prop("files")[0];
          var form_data = new FormData();
          form_data.append("file", file_data);
          form_data.append("action", "file_upload");

          jQuery.ajax({
            url : "'.site_url().'/wp-admin/admin-ajax.php",
            type: "POST",
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                jQuery("#"+form_id+" .imginput").val(response);
            }
          });
        });

    jQuery(document).ready(function($){
      $(".onoff_seller_notification").parent().click(function() {   
        var type_seller = $(this).parent().attr("data-toggle-seller-status");
        if($(this).hasClass("off")){
          jQuery("#form_seller_notification"+type_seller).show();
          jQuery.ajax({
            url : "'.site_url().'/wp-admin/admin-ajax.php",
            data : "data=checked&tipe="+type_seller+"&action=onoff_seller_notification",
            method : "POST",
          });
        }else{
          jQuery("#form_seller_notification"+type_seller).hide();
          jQuery.ajax({
            url : "'.site_url().'/wp-admin/admin-ajax.php",
            data : "data=&action=onoff_seller_notification&tipe="+type_seller,
            method : "POST",
          });
        } 
      });
    });

    jQuery(document).ready(function($){
      $(".onoff_seller_notification_setting").parent().click(function(){
        if($(this).hasClass("off")){
          jQuery("#form_seller_notification_setting").show();
          jQuery.ajax({
            url : "'.site_url().'/wp-admin/admin-ajax.php",
            data : "data=checked&action=onoff_seller_notification_setting",
            method : "POST",
          });
        }else{
          jQuery("#form_seller_notification_setting").hide();
          jQuery.ajax({
            url : "'.site_url().'/wp-admin/admin-ajax.php",
            data : "data=&action=onoff_seller_notification_setting&",
            method : "POST", 
          });
        } 
      });
    });
    
    function pop_up_seller_notif(id){
			jQuery("#btn-delete-custom-form").attr("onclick", "return ajax_delete_seller_notif("+id+");");
			jQuery("#btn-update-custom-form").attr("onclick", "return update_seller_notif("+id+");");
		}

    function ajax_delete_seller_notif(id){
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : "id="+id+"&action=delete_seller_notif",
			    method : "POST",
				success :
					jQuery("#seller_"+id).remove(),
			    error : function(error){  }
			});

			return false;
    }
    
    function ajax_add_new_seller(){
			var name = jQuery("#name-form").val();
      var wa_number = jQuery("#whatsapp-form").val();
      var all = jQuery("input[name=alllist]").val();

      var select = [];
      $(".checbox_template_seller:checked").each(function() {
        select.push($(this).val());
      });
    		jQuery.ajax({
			    url : "'.site_url().'/wp-admin/admin-ajax.php",
			    data : "wa_number="+wa_number+"&name="+name+"&select="+select+"&alllist="+all+"&action=save_new_seller_form",
			    method : "POST",
				success : function( response ){
					//jQuery("#accordion").append( response );
					location.reload();
				},
			    error : function(error){  }
			});

			return false;
    }
    
    jQuery(document).ready(function($){
			$(".toggle-seller-list").parent().on("click",function() {
				var id = $(this).parent().attr("data-seller-notif-id");
          if($(this).hasClass("off")){
            jQuery.ajax({
              url : "'.site_url().'/wp-admin/admin-ajax.php",
              data : "data=checked&id="+id+"&action=onoff_seller_list",
              method : "POST",
            });
          }else{
            jQuery.ajax({
              url : "'.site_url().'/wp-admin/admin-ajax.php",
              data : "data=&id="+id+"&action=onoff_seller_list",
              method : "POST", 
          });
        }
			});
    });

    function titleCase(str) {
      var splitStr = str.toLowerCase().split(" ");
      for (var i = 0; i < splitStr.length; i++) {
          // You do not need to check if i is larger than splitStr length, as your for does that for you
          // Assign it back to the array
          splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
      }
      // Directly return the joined string
      return splitStr.join(" "); 
   }

    function ajax_update_seller_list(id){
      var name = jQuery("#name-form-"+id).val();
      var wa_number = jQuery("#whatsapp-form-"+id).val();
      var all = jQuery("input[name=alllist"+id+"]").val();
			var select = [];
      $("#checbox_template_seller"+id+":checked").each(function() {
        select.push($(this).val());"+id+"
      });

      jQuery.ajax({
        url : "'.site_url().'/wp-admin/admin-ajax.php",
        data : "id="+id+"&select="+select+"&alllist="+all+"&wa_number="+wa_number+"&name="+name+"&action=update_seller_notif",
        method : "POST",
        success : function (r){
          if(Array.isArray(select) && select.length){
            var res = select.join(", ");
            var res = res.replace(/_/g, " ");
            jQuery("#seller_notif_select"+id).html(titleCase(res));
          }else{
            var all_templates = all.replace(/_/g, " ");
            jQuery("#seller_notif_select"+id).html(titleCase(all_templates));
          }
          
          
          jQuery("#seller_notif_name"+id).html(name);
          jQuery("#seller_notif_no_wa"+id).html(wa_number);
        },
        error : function(error){  }
			});
			return false;
    }
    
    $(".checbox_template_seller").click(function () {
      $(".checkAll").prop("checked", false);
    });

    $(".checkAll").click(function () {
      $(".checbox_template_seller").prop("checked", false);
    });

    </script>';

    return $script;
}

?>