<?php

namespace app;

use GuzzleHttp\RequestOptions;
use Unirest\Request;

require_once 'vendor/autoload.php';

class RestClient
{
    public $endpoint;

    public function __construct()
    {
        $this->endpoint = 'https://api.tsobu.co.ke';
    }

    public function sendSMSGuzzle(array $data)
    {
        $client = new \GuzzleHttp\Client(array(
            'base_uri' => $this->endpoint,
            'http_errors' => false
        ));
        $response = $client->post("v1/sms/single", [
            RequestOptions::JSON => json_encode($data)
        ]); //request('POST', "v1/sms/single");

        if ($response->getStatusCode() === 200) {
            return $response;
        } else {
            return $response->getReasonPhrase();
        }
    }

    public function sendSMSUniRest(array $data)
    {
        $headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        );

        //Request::verifyPeer(false); // Disables SSL cert validation
        $body = Request\Body::Json($data);

        $response = Request::post("{$this->endpoint}/v1/sms/single", $headers, $body);

        return $response->body;
    }

    public function sendSMSNonCurl(array $data)
    {

        $url = "{$this->endpoint}/v1/sms/single";
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => "Accept: application/json\r\n" . "Content-Type: application/json\r\n",
                'content' => json_encode($data)
            )
        );
        $context = stream_context_create($opts);
        $result = @file_get_contents($url, false, $context);

        return $result;
    }
}