<?php

namespace Finolog;

class Api
{
    /** @var \GuzzleHttp\Client  */
    private $http_client;

    /**
     * Api constructor.
     * @param $apiToken
     */
    public function __construct($apiToken)
    {
        $this->http_client = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.finolog.ru/v1/',
            'headers' => [
                'Api-Token' => $apiToken,
                'User-Agent' => 'finolog/sdk-php'
            ]
        ]);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $payload
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request(string $method, string $uri, array $payload = []) {
        return json_decode(
            $this->http_client
                ->request($method, $uri, ['json' => $payload])
                ->getBody()
                ->getContents()
        );
    }
}
