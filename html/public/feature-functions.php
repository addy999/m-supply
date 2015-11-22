<?php

	// Function to call to perform stock query. Returns resultant message to send.
	function stock($parameters) {
		$vendor_id = substr($parameters, 0, 6);
		$item_name = substr($parameters, 7);
		$item_id = get_item_id($item_name);
		
		$vendor_item = make_call("vendor_ID/" . $vendor_id . "/items/" . $item_id);
		
		$outgoing = "";
		
		if ($vendor_item->{"has"}) {
			$outgoing .= "Yes, " . $vendor_id . " has " . $item_name . " in stock.";
		} else {
			$outgoing .= "No, " . $vendor_id . " does not have " . $item_name . " in stock.";
		}
		
		return $outgoing;
	}
?>