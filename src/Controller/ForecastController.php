<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

use App\Utils\Forecast;

class ForecastController extends AbstractController
{

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function index(): Response
    {
        if ($_ENV['APP_ENV'] == 'test') {
            $test = true;
        } else {
            $test = false;
        }

        $forecast = new Forecast($this);

        $cities = $forecast->fetchCities();
        $publicroot = realpath("./../public");
        $stdout = fopen("php://stdout", "w");
        if (!$test) {
            $fileout = fopen($publicroot . "/console.log", "w");
        }
        foreach ($cities as $city) {

            $weather = $forecast->fetchForecast($city["latitude"], $city["longitude"]);

            $today = $weather["forecast"]["forecastday"]["0"]["day"]["condition"]["text"];
            $tomorrow = $weather["forecast"]["forecastday"]["1"]["day"]["condition"]["text"];

            $text = "Processed city " . $city["name"] . " | " . $today . " - " . $tomorrow;

            fwrite($stdout, $text . "\n");
            if (!$test) {
                fwrite($fileout, $text . "\n");
            }
        }

        fclose($stdout);
        if (!$test) {
            fclose($fileout);
        } else {
            $_SERVER['HTTP_HOST'] = "127.0.0.1:8000";
        }

        $actual_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
        $log_url = $actual_url . "/console.log";
        return $this->json([
            'message' => 'Forecast loaded. Please check console messages, or in the following url shown.',
            'url' => $log_url
        ]);

    }
}
