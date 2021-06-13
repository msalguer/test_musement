<?php

namespace App\Utils;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\HttpClient\HttpClient;

class Forecast
{
    const APIKEY = "a47754e48c464c1682683751211006";
    const URLCITIES = "https://sandbox.musement.com/api/v3/cities";
    const URLFORECAST = "https://api.weatherapi.com/v1/forecast.json?key=" . self::APIKEY . "&q=[lat],[lon]&days=2";

    /**
     * Forecast constructor.
     * @param $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function fetchCities(): array
    {
        $client = HttpClient::create();
        $response = $client->request(
            'GET',
            self::URLCITIES
        );
        return $response->toArray();
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function fetchForecast(string $lat, string $lon): array
    {

        $url = str_replace("[lat]", $lat, self::URLFORECAST);
        $url = str_replace("[lon]", $lon, $url);

        $client = HttpClient::create();
        $response = $client->request(
            'GET',
            $url
        );
        return $response->toArray();
    }

}
