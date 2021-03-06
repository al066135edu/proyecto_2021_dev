<?php declare(strict_types=1);

namespace App\Tests\Functional\Frontend;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// ./vendor/phpunit/phpunit/phpunit tests/Functional/Frontend/HomePageRoutingTest.php
// ./vendor/phpunit/phpunit/phpunit --filter=testHomePage
// TIP: SYMFONY_DEPRECATIONS_HELPER=disabled ./vendor/phpunit/phpunit/phpunit tests/Functional/Frontend/HomePageRoutingTest.php --stop-on-failure --testdox
final class HomePageRoutingTest extends WebTestCase
{
    public function testHomePage(): void
    {
        $client = self::createClient();
        $client->request('GET', 'http://localhost:8000');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenidos al Curso de Symfony Fue');
    }
}
