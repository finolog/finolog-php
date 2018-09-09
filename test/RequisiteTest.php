<?php

use PHPUnit\Framework\TestCase;

use Finolog\Client;
use Finolog\Requisite;

final class RequisiteTest extends TestCase
{

    /** @var int */
    protected static $bizID;

    /** @var int */
    protected static $contractorID;

    /** @var Requisite */
    protected static $requisite;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static  function setUpBeforeClass() {
        $dotenv = new Dotenv\Dotenv(realpath(__DIR__ . '/..'));
        $dotenv->load();
        $client = new Client($_ENV['API_TOKEN']);
        self::$bizID = $client->biz->all()[0]->id;
        self::$contractorID = $client->contractor->all(['biz_id' => self::$bizID])[0]->id;
        self::$requisite = $client->requisite;
    }

    /**
     * @test
     * @testdox Add new requisite
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add() {
        $requisite = self::$requisite->add(['biz_id' => self::$bizID, 'name' => 'requisite name', 'contractor_id' => self::$contractorID]);
        $this->assertEquals($requisite->name, 'requisite name');
        return $requisite;
    }

    /**
     * @test
     * @testdox Get requisite
     * @depends add
     * @param stdClass $requisite
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(stdClass $requisite) {
        $response = self::$requisite->get(['biz_id' => self::$bizID, 'id' => $requisite->id]);
        $this->assertEquals($response->id, $requisite->id);
        return $response;
    }

    /**
     * @test
     * @testdox Get all requisites
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all() {
        $requisite = self::$requisite->all(['biz_id' => self::$bizID]);
        $this->assertInternalType('array', $requisite);
    }

    /**
     * @test
     * @testdox Update requisite
     * @depends get
     * @param stdClass $requisite
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(stdClass $requisite) {
        $response = self::$requisite->update(['biz_id' => self::$bizID,'id' => $requisite->id, 'name' => 'new test requisite name']);
        $this->assertEquals($response->name, 'new test requisite name');
    }

    /**
     * @test
     * @testdox Delete requisite
     * @depends get
     * @param stdClass $requisite
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(stdClass $requisite) {
        $response = self::$requisite->delete(['biz_id' => self::$bizID, 'id' => $requisite->id]);
        $this->assertNotNull($response->deleted_at);
    }

}
