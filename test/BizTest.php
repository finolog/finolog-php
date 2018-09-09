<?php

use PHPUnit\Framework\TestCase;

use Finolog\Client;
use Finolog\Biz;

/**
 * @testdox Biz
 */
final class BizTest extends TestCase
{

    /** @var Biz */
    protected static $biz;

    public static  function setUpBeforeClass() {
        $dotenv = new Dotenv\Dotenv(realpath(__DIR__ . '/..'));
        $dotenv->load();
        $client = new Client($_ENV['API_TOKEN']);
        self::$biz = $client->biz;
    }

    /**
     * @test
     * @testdox Add new business
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add() {
        $biz = self::$biz->add(['name' => 'test business name', 'base_currency_id' => 1]);
        $this->assertEquals($biz->name, 'test business name');
        return $biz;
    }

    /**
     *
     * @test
     * @testdox Get business
     * @depends add
     * @param stdClass $biz
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(stdClass $biz) {
        $response = self::$biz->get(['biz_id' => $biz->id]);
        $this->assertEquals($response->id, $biz->id);
        return $response;
    }

    /**
     *
     * @test
     * @testdox Get all business
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all() {
        $biz = self::$biz->all();
        $this->assertInternalType('array', $biz);
        return $biz;
    }

    /**
     *
     * @test
     * @testdox Update business
     * @depends get
     * @param stdClass $biz
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(stdClass $biz) {
        $response = self::$biz->update(['biz_id' => $biz->id, 'name' => 'new test business name']);
        $this->assertEquals($response->name, 'new test business name');
        return $response;
    }

    /**
     * @test
     * @testdox Delete business
     * @depends get
     * @param stdClass $biz
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(stdClass $biz) {
        $response = self::$biz->delete(['biz_id' => $biz->id]);
        $this->assertTrue($response->success);
    }

}
