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

        $expected = json_encode(array('message' => 'Forecast loaded. Please check console messages.'));
        $response = $forecast->index();
        $this->assertEquals($expected, $response->getContent());
    }

}