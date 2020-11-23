jQuery(function(){
    var btn_bulk='<br><div class="dropdown">        <button class="btn btn-sm btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">            Send Bulk <i class="fab fa-whatsapp"></i>        </button>        <div class="dropdown-menu" aria-labelledby=".dropdown-toggle">            <a class="dropdown-item" href="#" class="a_reminder_btn btn-reminder" onclick="return bulk_send_reminder_woowa(0)"> Default </a>            <a class="dropdown-item" href="#" class="a_reminder_btn btn-reminder" onclick="return bulk_send_reminder_woowa(1)"> Template 1 </a>            <a class="dropdown-item" href="#" class="a_reminder_btn btn-reminder" onclick="return bulk_send_reminder_woowa(2)"> Template 2 </a>            <a class="dropdown-item" href="#" class="a_reminder_btn btn-reminder" onclick="return bulk_send_reminder_woowa(3)"> Template 3 </a>        </div>    </div>';
    jQuery("#woowa-columns").append(btn_bulk);
    jQuery("input[type=checkbox]").click(function(){
        var centang=jQuery(this).prop("checked");
        if(centang==true){
            jQuery(this).parent().parent().find("td.woowa-columns").find("a.a_reminder_btn").addClass("bulk_send");
        }else{
            jQuery(this).parent().parent().find("td.woowa-columns").find("a.a_reminder_btn").removeClass("bulk_send");
        } 
    });

    jQuery("#cb-select-all-1").click(function(){
        var centang=jQuery(this).prop("checked");
        if(centang==true){
            jQuery("a.a_reminder_btn").addClass("bulk_send");
        }else{
            jQuery("a.a_reminder_btn").removeClass("bulk_send");
        }
    });
});

function bulk_send_reminder_woowa(template){
    jQuery(".bulk_send.btn-reminder-"+template).click(); 
    return false;
}

function ajax_force_reminder_order(that,post_id, ke){
    var ke = ke;
    jQuery(that).parent().parent().after("<span class=notif >sending...</span>");
    jQuery.ajax({
        url : "admin-ajax.php",
        data : "action=force_reminder_order&post_id="+post_id+"&ke="+ke,
        method : "POST", 
        success : function( response ){ 
            jQuery(that).parent().parent().parent().find(".notif").html("WA sent");
        },
        error : function(error){  }
    });
    return false;
}

jQuery(document).ready(function () {
    jQuery('.dropdown button').click();
});

