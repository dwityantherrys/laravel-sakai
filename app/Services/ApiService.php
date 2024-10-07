<?php

// app/Services/ApiService.php
namespace App\Services;

use GuzzleHttp\Client;

class ApiService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://10.25.202.144:5252',
            'timeout'  => 20.0,  // Set timeout for the API request
        ]);
    }

    public function getData($endpoint)
    {
        $response = $this->client->request('GET', $endpoint);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody(), true);
        }

        return null;
    }
}
