<?php

namespace App\ParserBundle\Infrastructure\Shared\Client;

use App\ParserBundle\Domain\ShoprenterWorkerService;
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


    public function getWorkerByEmail(string $email)
    {
        try {
            $response = $this->client->post('http://nginx/remote_user/user', [
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

    public function authenticate($username, $password): array
    {
        try {
            $response = $this->client->post('http://nginx/remote_user/user/auth', [
                'form_params' => [
                    'email' => $username,
                    'password' => $password
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

    public function getWorkerById(int $id)
    {
        try {
            $response = $this->client->get('http://nginx/remote_user/user/' . $id, [
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