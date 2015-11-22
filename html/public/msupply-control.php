<?php
    require_once("core-functions.php");
    require_once("feature-functions.php");
    
    $base_url = 'https://m-supply.firebaseio.com/';
    $end_url = ".json";
    $commands = ["stock", "update"];
    
    $incoming = strtolower($_POST["Body"]);
    $outgoing;
    
    $command = substr($incoming, 0, strpos(" "));
    $parameters = substr($incoming, strpos(" ") + 1);
    
    switch($command) {
        case $commands[0]:
            $outgoing = stock($parameters);
            break;
        case $commands[1];
            $outgoing = update($parameters);
            break;
    }
    
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Message><?php echo $outgoing ?></Message>
</Response>