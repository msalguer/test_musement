<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

use App\Utils\Forecast;

class ForecastController extends AbstractController
{

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function index(): Response
    {
        $forecast = new Forecast($this);

        $cities = $forecast->fetchCities();

        //var_dump($cities);
        //for i=0,len($cities),i++ {
        foreach ($cities as $city) {

            $weather = $forecast->fetchForecast($city["latitude"], $city["longitude"]);

            $today = $weather["forecast"]["forecastday"]["0"]["day"]["condition"]["text"];
            $tomorrow = $weather["forecast"]["forecastday"]["1"]["day"]["condition"]["text"];

            $text = "Processed city " . $city["name"] . " | " . $today . " - " . $tomorrow;
            $stdout = fopen("php://stdout", "w");
            fwrite($stdout, $text . "\n");
            fclose($stdout);

        }

        return $this->json([
            'message' => 'Forecast loaded. Please check console messages.',
        ]);

    }
}
