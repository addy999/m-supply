<?php
	// Make standardized database GET call
    function make_get_call($mid_url, $type, $params) {
        global $base_url, $end_url;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $base_url . $mid_url . $end_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        
        $output = json_decode(curl_exec($curl));
        curl_close($curl);
        
        return $output;
    }
    
    // Make standardized database PUT call
    function make_put_call($mid_url, $put_values) {
        global $base_url, $end_url;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $base_url . $mid_url . $end_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($put_values));
        
        $output = curl_exec($curl);
        curl_close($curl);
        
        return $output;
    }
    
    // Return item index of $item_name if exists. Otherwise return FALSE.
    function get_item_id($item_name) {
        $item_list = make_get_call("items");
        
        foreach ($item_list as $key => $value) {
            if (strtolower($value) == $item_name) return $key;
        }
        
        return $item_list;
    }
?>