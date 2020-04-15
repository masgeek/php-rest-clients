<?php
require_once 'vendor/autoload.php';
require_once 'RestClient.php';

$client = new \app\RestClient();

$data = array(
    "GSM" => "+254713196504",
    "SMSText" => "This is a test message",
    "password" => "",
    "user" => ""
);

$resp = $client->sendSMSGuzzle($data);
//$resp = $client->sendSMSUniRest($data);
//$resp = $client->sendSMSNonCurl($data);
?>
<pre>
    <?php
    var_dump($resp);
    ?>
</pre>