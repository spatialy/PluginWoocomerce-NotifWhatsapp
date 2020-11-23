<?php 

function woowa_wizard_setup_view(){
    $view = '<br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="' . site_url() . '/wp-content/plugins/pelanggan/public/js/bootstrap.min.js"></script>
    <script src="' . site_url() . '/wp-content/plugins/pelanggan/public/js/chart.js"></script>    
    <script src="' . site_url() . '/wp-content/plugins/pelanggan/public/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="' . site_url() . '/wp-content/plugins/pelanggan/public/css/bootstrap-toggle.min.css">
    <link rel="stylesheet" href="' . site_url() . '/wp-content/plugins/pelanggan/public/css/bootstrap4.min.css">
    <link rel="stylesheet" href="' . site_url() . '/wp-content/plugins/pelanggan/public/css/woowa.css?v=0.1.21">
    <link rel="stylesheet" href="' . site_url() . '/wp-content/plugins/pelanggan/public/css/varelaround.css">
    <link rel="stylesheet" href="' . site_url() . '/wp-content/plugins/pelanggan/public/css/vertical-tab.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css"  />
    <style>
        .label-nav{
        display:none;
        }
    </style>
    <script type="text/javascript">
        jQuery(function(){
            jQuery(".nav").find("li").on("click",function(){
                jQuery(".label-nav").hide();
                jQuery(this).find("a").find("span").show();
            });

            jQuery(".wp-has-submenu").hover(
                function() {
                    jQuery( this ).addClass("opensub");
                }, function() {
                    jQuery( this ).removeClass("opensub");
                }
            );
        });
    </script>
	
	<div class="container">
        <h3 style="margin-top:5px;">Setup Wizard</h3>
        <p>Hello! Thank you for using Pelanggan.NET!</p>
        <p>Let us help you to setup Pelanggan.NET to fit the needs of your store</p>

        <h4 style="margin-top:50px;">Which templates do you need?</h4>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="after_checkout" value="after_checkout">
            <label class="form-check-label" for="after_checkout"> After Checkout</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="order_completed" value="order_completed">
            <label class="form-check-label" for="order_completed"> Order Completed</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="reminder_order" value="reminder_order">
            <label class="form-check-label" for="reminder_order"> Reminder Order</label>
        </div><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="cancel_order" value="cancel_order">
            <label class="form-check-label" for="cancel_order"> Cancel Order</label>
        </div>
        <div class="form-check form-check-inline" style="margin-left: 14px;">
            <input class="form-check-input" type="checkbox" id="order_process" value="order_process">
            <label class="form-check-label" for="order_process"> Order Process</label>
        </div>
        <div class="form-check form-check-inline" style="margin-left: 25px;">
            <input class="form-check-input" type="checkbox" id="order_refund" value="order_refund">
            <label class="form-check-label" for="order_refund"> Order Refund</label>
        </div><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="order_failed" value="order_failed">
            <label class="form-check-label" for="order_failed"> Order Failed</label>
        </div>
        <div class="form-check form-check-inline" style="margin-left: 19px;">
            <input class="form-check-input" type="checkbox" id="pending_payment" value="pending_payment">
            <label class="form-check-label" for="pending_payment"> Pending Payment</label>
        </div>
        <div class="form-check form-check-inline" style="margin-bottom: 20px;">
            <input class="form-check-input" type="checkbox" id="abandoned_cart" value="abandoned_cart">
            <label class="form-check-label" for="abandoned_cart"> Abandoned Cart</label>
        </div>
        <h4 style="margin-top:50px;">Which features do you need?</h4>
	</div>
	';

	return $view;
}