<?php
    require_once("core-functions.php");
    
    $base_url = 'https://m-supply.firebaseio.com/';
    $end_url = ".json";
    
    $command_list = ["stock", "update"]
    
    $incoming = strtolower($_POST["Body"]);
    $command = substr($incoming, 0, strpos(" "));
    $parameters = substr($incoming, strpos(" ") + 1);
    
    $vendor_id = substr($incoming, 0, 6);
    $item_name = substr($incoming, 7);
    $item_id = get_item_id($item_name);
    
    $vendor_item = make_call("vendor_ID/" . $vendor_id . "/items/" . $item_id);
    
    $outgoing = "";
    
    if ($vendor_item->{"has"}) {
        $outgoing .= "Yes, " . $vendor_id . " has " . $item_name . " in stock.";
    } else {
        $outgoing .= "No, " . $vendor_id . " does not have " . $item_name . " in stock.";
    }
    
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Message><?php echo $outgoing ?></Message>
</Response>