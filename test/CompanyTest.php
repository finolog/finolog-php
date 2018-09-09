<?php

use PHPUnit\Framework\TestCase;

use Finolog\Client;
use Finolog\Company;

final class CompanyTest extends TestCase
{

    /** @var int */
    protected static $bizID;

    /** @var Company */
    protected static $company;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static  function setUpBeforeClass() {
        $dotenv = new Dotenv\Dotenv(realpath(__DIR__ . '/..'));
        $dotenv->load();
        $client = new Client($_ENV['API_TOKEN']);
        self::$bizID = $client->biz->all()[0]->id;
        self::$company = $client->company;
    }

    /**
     * @test
     * @testdox Add new company
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add() {
        $contractor = self::$company->add(['biz_id' => self::$bizID, 'name' => 'company name']);
        $this->assertEquals($contractor->name, 'company name');
        return $contractor;
    }

    /**
     * @test
     * @testdox Get company
     * @depends add
     * @param stdClass $company
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(stdClass $company) {
        $response = self::$company->get(['biz_id' => self::$bizID,'id' => $company->id]);
        $this->assertEquals($response->id, $company->id);
        return $response;
    }

    /**
     * @test
     * @testdox Get all company
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all() {
        $contractor = self::$company->all(['biz_id' => self::$bizID]);
        $this->assertInternalType('array', $contractor);
    }

    /**
     * @test
     * @testdox Update company
     * @depends get
     * @param stdClass $company
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(stdClass $company) {
        $response = self::$company->update(['biz_id' => self::$bizID,'id' => $company->id, 'name' => 'new test company name']);
        $this->assertEquals($response->name, 'new test company name');
    }

    /**
     * @test
     * @testdox Delete company
     * @depends get
     * @param stdClass $company
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(stdClass $company) {
        $response = self::$company->delete(['biz_id' => self::$bizID, 'id' => $company->id]);
        $this->assertTrue($response->success);
    }

}
