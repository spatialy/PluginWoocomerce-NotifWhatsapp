<?php


function woowa_quota_harian_chart($return = false){
	$domain = $_SERVER['SERVER_NAME'];
	$license_key = get_option('woowa_license_number');
	if (isset($_POST['start'])) {
		$start = $_POST['start'];
		$end = $_POST['end'];
		$url = get_option('STATISTIC').'license='.$license_key.'&'.'domain='.$domain.'&dari='.$start.'&sampai='.$end;
	}else{
		$url = get_option('STATISTIC').'license='.$license_key.'&'.'domain='.$domain;
	}
	// echo $url;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	$r = curl_exec($ch);
  	$err = curl_error($ch);
  	curl_close ($ch);

  	if ($r) {
 		return $r;
  	}else {
		die($r);
  	}
}

function woowa_quota_harian_table(){
	woowa_statistic_table_view(true);
}

function woowa_statistic_table_view($return = false){
	$domain = $_SERVER['SERVER_NAME'];
	$license_key = get_option('woowa_license_number');
	if (isset($_POST['from'])) {
		$start = $_POST['from'];
		$end = $_POST['to'];
		$url = get_option('STATISTIC').'license='.$license_key.'&'.'domain='.$domain.'&dari='.$start.'&sampai='.$end;
	}else{
		$url = get_option('STATISTIC').'license='.$license_key.'&'.'domain='.$domain;
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	$r = curl_exec($ch);
  	$err = curl_error($ch);
  	curl_close ($ch);

	$array = json_decode($r, TRUE);
	$table='
		<table class="table table-hover " id="table_statistic">
			<thead>
				<tr>
					<th>No</th>
					<th>Domain</th>
					<th>Date</th>
					<th>After Checkout</th>
					<th>Order Complete</th>
					<th>Reminder Order</th>
					<th>Cancel Order</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>';
			if (!empty($array)) {	
				foreach ($array as $k => $v) {
					$table.='<tr align="">
					<td align="" id="nolist">'. ($k+1) .'</td>
					<td>'. $v['domain'] .'</td>
					<td>'. date("M,d Y",strtotime($v['tgl'])) .'</td>
					<td>'. number_format($v['after_checkout']) .'</td>
					<td>'. number_format($v['order_complete']) .'</td>
					<td>'. number_format($v['reminder_order']) .'</td>
					<td>'. number_format($v['cancel_order']) .'</td>
					<td>'. number_format($v['jml']) .'</td>
					</tr>';
					
				}
			}
			$table .='	
			</tbody>
		</table>
	';
	if ($return) {
		die($table);
	}else {
		return $table;
	}
}