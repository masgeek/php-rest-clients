<?php

namespace app;

use Unirest\Request;

require_once 'vendor/autoload.php';

class RestClient
{
    public $endpoint;
    public $headers;

    public function __construct()
    {
        $this->endpoint = 'https://api.tsobu.co.ke';
//        $this->endpoint = 'http://127.0.0.1:9000/api';
        $this->headers = array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        );
    }

    public function sendSMSGuzzle(array $data)
    {
        $client = new \GuzzleHttp\Client(array(
            'base_uri' => $this->endpoint,
            'http_errors' => false
        ));

        $response = $client->post("v1/sms/single", array(
            'headers' => $this->headers,
            'body' => json_encode($data)
        ));
        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody());;
        } else {
            return $response->getReasonPhrase();
        }
    }

    public function sendSMSUniRest(array $data)
    {

        //Request::verifyPeer(false); // Disables SSL cert validation
        $body = Request\Body::Json($data);

        $response = Request::post("{$this->endpoint}/v1/sms/single", $this->headers, $body);

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