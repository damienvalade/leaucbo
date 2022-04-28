<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ClientRequestService
{
    private ResponseInterface $response;
    private HttpClientInterface $client;

    public function __construct(
        HttpClientInterface $client
    ) {
        $this->client = $client;
    }

    public function request(array $query)
    {
        $response = $this->client->request(
            'GET',
            'https://hubeau.eaufrance.fr/api/vbeta/qualite_eau_potable/resultats_dis',
            [
                'query' => $query
            ]
        );

        $content = $response->getContent();
        $content = $response->toArray();

        return $content;
    }


    public function httpClientChunks($data)
    {
        foreach ($data as $chunk) {
            return yield $chunk->getContent();
        }
    }
}
