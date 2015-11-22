<?php
    $base_url = 'https://m-supply.firebaseio.com/';
    $end_url = ".json";

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
        
        return FALSE;
    }
    
    $incoming = strtolower($_POST["Body"]);
    
    $vendor_id = substr($incoming, 0, 6);
    $item_name = substr($incoming, 7);
    $item_id = get_item_id($item_name);
    
    $vendor_item = make_call("vendor_ID/" . $vendor_id . "/items/" . $item_id);
    
    $outgoing = "";
    
    if ($vendor_item["has"]) {
        $outgoing .= "Yes, " . $vendor_id . " has " . $item_name . " in stock.";
    } else {
        $outgoing .= "No, " . $vendor_id . " does not have " . $item_name . " in stock.";
    }
    
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Message><?php echo var_dump($item_id) ?></Message>
</Response>