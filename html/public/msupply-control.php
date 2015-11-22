<?php
    require_once("core-functions.php");
    require_once("feature-functions.php");
    require_once("twilio/Services/Twilio.php");
    
    $account_sid = 'ACbc8c562cb1021b017d9084070c5996c3'; 
    $auth_token = '88cb261f40a7aad55836c284a7db820a'; 
    $account_phone = "+14387950306";
    $client = new Services_Twilio($account_sid, $auth_token); 
    
    $base_url = 'https://m-supply.firebaseio.com/';
    $end_url = ".json";
    $commands = ["stock", "update"];
    
    $incoming = strtolower($_POST["Body"]);
    $outgoing;
    
    $command = "";
    $parameters = "";
    
    if (gettype(strpos($incoming, " ")) != "boolean") {
        $command = substr($incoming, 0, strpos($incoming, " "));
        $parameters = substr($incoming, strpos($incoming, " ") + 1);
    } else {
        $command = $incoming;
        $parameters = "";
    }
    
    switch($command) {
        case $commands[0]:
            $outgoing = stock($parameters);
            break;
        case $commands[1]:
            $outgoing = update($parameters);
            break;
        default:
            $outgoing = notify_request($command);
            break;
    }
    
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Message><?php echo $outgoing ?></Message>
</Response>