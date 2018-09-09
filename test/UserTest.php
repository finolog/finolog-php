<?php

use PHPUnit\Framework\TestCase;

use Finolog\Client;
use Finolog\User;

final class UserTest extends TestCase
{
    /** @var User */
    private $user;

    protected function setUp() {
        $dotenv = new Dotenv\Dotenv(realpath(__DIR__ . '/..'));
        $dotenv->load();
        $client = new Client($_ENV['API_TOKEN']);
        $this->user = $client->user;
    }

    /**
     * @test
     * @testdox Get authorized user
     */
    public function testGet() {
        $user = $this->user->get();
        $this->assertObjectHasAttribute('id', $user);
    }

    /**
     * @test
     * @testdox Update authorized user
     */
    public function testUpdate() {
        $user = $this->user->update(['first_name' => 'new user name']);
        $this->assertEquals($user->first_name ,'new user name');
    }
}
