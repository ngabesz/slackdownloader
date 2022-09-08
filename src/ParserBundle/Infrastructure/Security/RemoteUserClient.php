<?php

namespace App\ParserBundle\Infrastructure\Security;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use function json_decode;

class RemoteUserClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getRemoteUserByEmail(string $email)
    {
        try {
            $response = $this->client->post('http://localhost:8002/remote_user/user', [
                'form_params' => [
                    'email' => $email
                ],
                'headers' => [
                    'timeout' => 5
                ]
            ]);
        } catch (GuzzleException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}