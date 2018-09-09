<?php

use PHPUnit\Framework\TestCase;

use Finolog\Client;
use Finolog\Contractor;

final class ContractorTest extends TestCase
{

    /** @var int */
    protected static $bizID;

    /** @var Contractor */
    protected static $contractor;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static  function setUpBeforeClass() {
        $dotenv = new Dotenv\Dotenv(realpath(__DIR__ . '/..'));
        $dotenv->load();
        $client = new Client($_ENV['API_TOKEN']);
        self::$bizID = $client->biz->all()[0]->id;
        self::$contractor = $client->contractor;
    }

    /**
     * @test
     * @testdox Add new contractor
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add() {
        $contractor = self::$contractor->add(['biz_id' => self::$bizID, 'name' => 'contractor name']);
        $this->assertEquals($contractor->name, 'contractor name');
        return $contractor;
    }

    /**
     * @test
     * @testdox Get contractor
     * @depends add
     * @param stdClass $contractor
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(stdClass $contractor) {
        $response = self::$contractor->get(['biz_id' => self::$bizID,'id' => $contractor->id]);
        $this->assertEquals($response->id, $contractor->id);
        return $response;
    }

    /**
     * @test
     * @testdox Get all contractors
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all() {
        $contractor = self::$contractor->all(['biz_id' => self::$bizID]);
        $this->assertInternalType('array', $contractor);
    }

    /**
     * @test
     * @testdox Update contractor
     * @depends get
     * @param stdClass $contractor
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(stdClass $contractor) {
        $response = self::$contractor->update(['biz_id' => self::$bizID,'id' => $contractor->id, 'name' => 'new test contractor name']);
        $this->assertEquals($response->name, 'new test contractor name');
    }

    /**
     * @test
     * @testdox Delete contractor
     * @depends get
     * @param stdClass $contractor
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(stdClass $contractor) {
        $response = self::$contractor->delete(['biz_id' => self::$bizID, 'id' => $contractor->id]);
        $this->assertNotNull($response->deleted_at);
    }

}
