<?php

namespace App\Tests;

use App\Controller\ForecastController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ForecastAppTest extends WebTestCase
{

    public function testForecastController() //: void
    {
        self::bootKernel();

        // gets the special container that allows fetching private services
        $container = self::$container;
        $forecast = $container->get(ForecastController::class);

        $expected = 'Forecast loaded. Please check console messages, or in the following url shown.';
        $response = $forecast->index();
        $jsonresp = json_decode($response->getContent(), true);
        $this->assertEquals($expected, $jsonresp['message']);
    }

}