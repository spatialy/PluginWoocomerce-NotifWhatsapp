<?php

class MainSeller{
    
    public function get_setting($order_id, $type = 'after_checkout'){
        $dt['log'] = '';

        $data = get_option('woowa_seller_service_data');
        $data = json_decode($data, 1);
        $main = new Main();

        if (get_option('woowa_toggle_seller_notification_setting') == 'checked') {
            foreach ($data as $key => $v) {
                $selected = explode(',', $v['select']);
                
                if (in_array($type, $selected)) {
                    if (get_option('woowa_toggle_seller_notification'.$type) != '') {
                        if (get_option('woowa_toggle_seller_list'.$key) != '') {
                            $dt['flow'] = true;
                            $dt['wa_number'][$key] = $v['wa_number'];
                        }
                    }
                }
            }
        }
        
        return $dt;
    }
}