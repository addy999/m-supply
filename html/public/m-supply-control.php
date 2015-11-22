<?php
    $base_url = 'https://m-supply.firebaseio.com/';
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_HEADER, false); 
    
    $output = curl_exec($curl);
    curl_close($curl);

    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Message><?php echo "dick" ?></Message>
</Response>