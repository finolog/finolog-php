<?php

use PHPUnit\Framework\TestCase;

use Finolog\Client;

final class CurrencyTest extends TestCase
{
    /**
     * @test
     * @testdox Get all currency
     */
    public function testGet() {
        $dotenv = new Dotenv\Dotenv(realpath(__DIR__ . '/..'));
        $dotenv->load();
        $client = new Client($_ENV['API_TOKEN']);
        $currency = $client->currency->all();
        $this->assertInternalType('array', $currency);
    }
}
