<?php

function woowa_script_error_view(){
	$script = '<script type="text/javascript">
      function ajax_error_log(){
        jQuery.ajax({
          url : "'.site_url().'/wp-admin/admin-ajax.php",
          data : jQuery("#error_log").serialize(),
          method : "POST", 
          success : function( response ){ jQuery("#error_log").html(response);},
          error : function(error){  }
        });
        return false;
      }
    </script>';

    return $script;
}



?>