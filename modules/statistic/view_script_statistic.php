<?php

function woowa_script_statistic_view(){
	$script ='
	<script>
        jQuery(document).ready(function () {
            showGraph("quota_harian_chart");
            jQuery(\'#daterange\').daterangepicker();
            jQuery(\'#daterange\').daterangepicker(\'setDate\', \'today\');
        });

    	function showGraph(y,start=null,end=null){
    		{
                jQuery.post("'.site_url().'/wp-admin/admin-ajax.php", { action: y,start:start,end:end },
                function (data0)
                {
                	var data=JSON.parse(data0);
                    
                    var tgl = [];
                    var jml = [];
                    var after_checkout = [];
                    var order_complete = [];
                    var reminder_order = [];
                    var cancel_order = [];

                    for (var i in data) {
                        tgl.push(data[i].tgl);
                        jml.push(data[i].jml);
                        after_checkout.push(data[i].after_checkout);
                        order_complete.push(data[i].order_complete);
                        reminder_order.push(data[i].reminder_order);
                        cancel_order.push(data[i].cancel_order);
                    }

                    var chartdata = {
                        labels: tgl,
                        datasets: [
                            {
                            label: \'Total Sent\',
                            backgroundColor: \'#49e2ff\',
                            borderColor: \'#46d5f1\',
                            hoverBackgroundColor: \'#49e2ff\',
                            hoverBorderColor: \'#46d5f1\',
                            data: jml
                            },
                            {
                            label: \'After Checkout\',
                            backgroundColor: \'#849ee8\',
                            borderColor: \'#849ee8\',
                            hoverBackgroundColor: \'#849ee8\',
                            hoverBorderColor: \'#849ee8\',
                            data: after_checkout
                            },
                            {
                            label: \'Order Complete\',
                            backgroundColor: \'#84e8a4\',
                            borderColor: \'#84e8a4\',
                            hoverBackgroundColor: \'#84e8a4\',
                            hoverBorderColor: \'#84e8a4\',
                            data: order_complete
                            },
                            {
                            label: \'Reminder Order\',
                            backgroundColor: \'#e8dc84\',
                            borderColor: \'#e8dc84\',
                            hoverBackgroundColor: \'#e8dc84\',
                            hoverBorderColor: \'#e8dc84\',
                            data: reminder_order
                            },
                            {
                            label: \'Cancel Order\',
                            backgroundColor: \'#dc615d\',
                            borderColor: \'#dc615d\',
                            hoverBackgroundColor: \'#dc615d\',
                            hoverBorderColor: \'#dc615d\',
                            data: cancel_order
                            }
                        ]
                    };

                    var graphTarget = jQuery("#graphCanvas");

	                var barGraph = new Chart(graphTarget, {
	                    type: \'bar\',
	                    data: chartdata,
                        options: {
                            responsive: true,
                            legend: {
                                position: \'bottom\',
                            },
                            hover: {
                                mode: \'label\'
                            },
                            scales: {
                                xAxes: [{
                                        display: true,
                                        scaleLabel: {
                                            display: true,
                                            labelString: \'Date\'
                                        }
                                    }],
                                yAxes: [{
                                        display: true,
                                        ticks: {
                                            beginAtZero: true,
                                            steps: 10,
                                            stepValue: 10
                                        }
                                    }]
                            },
                            title: {
                                display: true,
                                text: \'Statistics WA Messages\'
                            }
                        }
	                });
                });
            }
    	}

        jQuery(function() {
            jQuery(\'input[name="daterange"]\').daterangepicker({
                opens: \'left\'
            }, function(start, end, label) {
                jQuery(\'#daterange\').daterangepicker();
                jQuery(\'#daterange\').on(\'apply.daterangepicker\', function(ev, picker) {
                        jQuery("#graphCanvas").remove();
                        jQuery("#chart-container").html("<canvas id=\'graphCanvas\'></canvas>");
                        var start = picker.startDate.format(\'YYYY-MM-DD\');
                        var end = picker.endDate.format(\'YYYY-MM-DD\');
                        showGraph("quota_harian_chart",start,end);
                        quota_harian_table(start,end);
                });
            });
        });

        function quota_harian_table(from,to){
            jQuery(\'#statistics_table\').html("<center><img src=\'' . site_url() . '/wp-content/plugins/pelanggan/public/img/tenor.gif\' style=\'width:50px;\'></center>");
                jQuery.ajax({
                    url : "'.site_url().'/wp-admin/admin-ajax.php",
                    data : "action=quota_harian_table&from="+from+"&to="+to,
                    method : "POST",
                    success : function(data){
                        jQuery(\'#statistics_table\').html(data);
                    },
                    error : function(error){}
                });
                return false;
            }

    </script>';

	return $script;
}