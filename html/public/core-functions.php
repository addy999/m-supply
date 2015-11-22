<?php
	// Make standardized database call
    function make_call($mid_url) {
        global $base_url, $end_url;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $base_url . $mid_url . $end_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_HEADER, false); 
        
        $output = json_decode(curl_exec($curl));
        curl_close($curl);
        
        return $output;
    }
    
    // Return item index of $item_name if exists. Otherwise return FALSE.
    function get_item_id($item_name) {
        $item_list = make_call("items");
        
        foreach ($item_list as $key => $value) {
            if (strtolower($value) == $item_name) return $key;
        }
        
        return $item_list;
    }
?>