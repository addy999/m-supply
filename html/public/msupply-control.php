<?php
    require_once("core-functions.php");
    require_once("feature-functions.php");
    
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
    <Message><?php echo var_dump($outgoing) ?></Message>
</Response>