<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Utils\Forecast;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class ForecastTest extends TestCase

{
    
    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testFetchForecast()
    {

        $lat = 24.461;
        $lon = 54.39;

        $forecast = new Forecast($this);
        $weather = $forecast->fetchForecast($lat, $lon);

        $this->assertIsArray($weather);
        $this->assertArrayHasKey("forecast", $weather);
        $this->assertArrayHasKey("forecastday", $weather["forecast"]);
        $this->assertArrayHasKey("0", $weather["forecast"]["forecastday"]);
        $this->assertArrayHasKey("1", $weather["forecast"]["forecastday"]);
        $this->assertArrayHasKey("day", $weather["forecast"]["forecastday"]["0"]);
        $this->assertArrayHasKey("condition", $weather["forecast"]["forecastday"]["0"]["day"]);
        $this->assertArrayHasKey("text", $weather["forecast"]["forecastday"]["0"]["day"]["condition"]);

    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testFetchCities()
    {

        $forecast = new Forecast($this);
        $cities = $forecast->fetchCities();

        $this->assertIsArray($cities);
        $this->assertArrayHasKey("name", $cities["0"]);
        $this->assertArrayHasKey("latitude", $cities["1"]);
        $this->assertArrayHasKey("longitude", $cities["2"]);

    }
}

