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
            $response = $this->client->post('http://localhost:8001/remote_user/user', [
                'email' => $email
            ]);
        } catch (GuzzleException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}