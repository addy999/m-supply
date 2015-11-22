<?php
	// Function to call to perform stock query. Returns resultant message to send.
	function stock($stock_parameters) {
		$vendor_id = substr($stock_parameters, 0, 6);
		$item_name = substr($stock_parameters, 7);
		$item_id = get_item_id($item_name);
		
		$vendor_item = make_get_call("vendor_ID/" . $vendor_id . "/items/" . $item_id);
		
		$outgoing = "";
		
		if ($vendor_item->{"has"}) {
			$outgoing .= "Yes, " . $vendor_id . " has " . $item_name . " in stock.";
			$record = record_request($vendor_id, $item_id, $_POST["From"], "no");
		} else {
			$outgoing .= "No, " . $vendor_id . " does not have " . $item_name . " in stock. Would you like to be notified when this vendor has " . $item_name . " in stock? Text 'yes' or 'no'.";
			$record = record_request($vendor_id, $item_id, $_POST["From"], "wait");
		}
		
		return $outgoing;
	}
	
	// Function to update vendor item stock. Returns resultant message to respond with.
	function update($update_parameters) {
		$vendor_id = substr($update_parameters, 0, 6);
		$update_parameters = substr($update_parameters, 7);
		$message = substr($update_parameters, strpos($update_parameters, "-") + 2);
		$update_parameters = substr($update_parameters, 0, strpos($update_parameters, "-") - 1);
		$has = substr($update_parameters, strrpos($update_parameters, " ") + 1);
		$item_name = substr($update_parameters, 0, strrpos($update_parameters, " "));
		
		$item_id = get_item_id($item_name);
		if($has == "no") $has = FALSE;
		else $has = TRUE;
		
		$values = ["has" => $has, "message" => $message];
		$response = make_put_call("vendor_ID/" . $vendor_id . "/items/" . $item_id, $values);
		
		$outgoing = "Successfully updated stock of " . $item_name . ".";
		
		// send notification
		if($has == TRUE) {
			delay(1000);
			$notify = send_notifications($vendor_id, $item_id);
		}
		
		return $outgoing;
	}
	
	// Function to handle yes/no messages as notification requests.
	function notify_request($command) {
		$phone = $_POST["From"];
		$requests = make_get_call("request_ID");
		
		$outgoing;
		
		foreach($requests as $key => $value) {
			if($value->{"notify"} == "wait" and $value->{"phone"} == $phone) {
				
				if($command == "yes") {
					$response = make_put_call("request_ID/" . $key . "/notify", TRUE);
					$outgoing = "You will be notified when this item is in stock.";
				} else {
					$response = make_put_call("request_ID/" . $key . "/notify", FALSE);
					$outgoing = "You will not receive any notifications about this item.";
				}
				
				break;
			}
		}
		
		return $outgoing;
	}
	
	// Send notifications to people who have requested and update database.
	function send_notifications($vendor_id, $item_id) {
		$requests = make_get_call("request_ID");
		
		$outgoing;
		
		foreach($requests as $key => $value) {
			if($value->{"notify"} == TRUE and $value->{"vendor_id"} == $vendor_id and $value->{"item_id"} == $item_id) {
				
				/*$client->account->messages->create(array( 
					'To' => $value->{"phone"}, 
					'From' => $account_phone, 
					'Body' => "Hey there! " . $vendor_id . " has " . $item_id . " in stock now!",
				));*/
				
				//update notify sent
				
				$outgoing = "hey";
				
			}
		}
		
		return $outgoing;
	}
?>