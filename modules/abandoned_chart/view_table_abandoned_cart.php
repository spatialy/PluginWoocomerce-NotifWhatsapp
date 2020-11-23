<?php

function woowa_table_abandoned_cart(){
    if (get_option('woowa_license') != 'active') {
        return '<br>please activate license code. click <a href="'.site_url().'/wp-admin/admin.php?page=pelanggan-net-settings"  aria-expanded="true">here</a>';
    }

    $data = array_reverse(woowa_get_abandoned_cart());
    $view = '
    <h3 style="center">Abandoned Cart List</h3>';

    $view .='
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col"><input type="checkbox" id="checkAllaban"></th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Product Name</th>
                <th scope="col">Time</th>
                <th scope="col">Action <button class="btn btn-success btn-xs bulk-abandoned" onclick="return ajax_bulk_abandoned()">Bulk Send WA</button><span id=""></span></th>
            </tr>
        </thead>
        <tbody>';
        
        foreach ($data as $key => $value) {
            $cart_contents = unserialize($value['cart_contents']);
            
            $products = Array();
            foreach ($cart_contents as $k => $v) {
                $products[] = $v['product_title'].' ('. $v['quantity'].')';
            }
            $product_name =  implode(', ',$products);

            $view .='
                <tr class="tabelel">
                    <th scope="row">'.($key+1).'</th>
                    <td><input type="checkbox" class="check_abandoned"></td>
                    <td>'.$value['name'].'</td>
                    <td>'.$value['phone'].'</td>
                    <td>'.$product_name.'</td>
                    <td>'.$value['time'].'</td>
                    <td class="abandoned_table"><a type="button" class="btn btn-success abandoned"  onclick="return ajax_send_wa_abandoned(\''.$value['id'].'\')">Send WA</a><span class="woowa-span" id="woowa-span'.$value['id'].'"></span></td>
                </tr>';
        }

        $view .= '
        </tbody>
    </table>';

    return $view;
}