<?php

use PHPUnit\Framework\TestCase;

use Finolog\Client;
use Finolog\Account;

final class AccountTest extends TestCase
{

    /** @var int */
    protected static $bizID;

    /** @var int */
    protected static $companyID;

    /** @var Account */
    protected static $account;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static  function setUpBeforeClass() {
        $dotenv = new Dotenv\Dotenv(realpath(__DIR__ . '/..'));
        $dotenv->load();
        $client = new Client($_ENV['API_TOKEN']);
        self::$bizID = $client->biz->all()[0]->id;
        self::$companyID = $client->company->all(['biz_id' => self::$bizID])[0]->id;
        self::$account = $client->account;
    }

    /**
     * @test
     * @testdox Add new account
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add() {
        $account = self::$account->add([
            'biz_id' => self::$bizID,
            'company_id' => self::$companyID,
            'currency_id' => 1,
            'name' => 'account name',
            'initial_balance' => 1000
        ]);
        $this->assertEquals($account->name, 'account name');
        $this->assertEquals($account->currency_id, 1);
        $this->assertEquals($account->initial_balance, 1000);
        return $account;
    }

    /**
     * @test
     * @testdox Get account
     * @depends add
     * @param stdClass $account
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(stdClass $account) {
        $response = self::$account->get(['biz_id' => self::$bizID,'id' => $account->id]);
        $this->assertEquals($response->id, $account->id);
        return $response;
    }

    /**
     * @test
     * @testdox Get all accounts
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all() {
        $account = self::$account->all(['biz_id' => self::$bizID]);
        $this->assertInternalType('array', $account);
    }

    /**
     * @test
     * @testdox Update account
     * @depends get
     * @param stdClass $account
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(stdClass $account) {
        $response = self::$account->update(['biz_id' => self::$bizID,'id' => $account->id, 'name' => 'new test account name']);
        $this->assertEquals($response->name, 'new test account name');
    }

    /**
     * @test
     * @testdox Delete account
     * @depends get
     * @param stdClass $account
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(stdClass $account) {
        $response = self::$account->delete(['biz_id' => self::$bizID, 'id' => $account->id]);
        $this->assertTrue($response->success);
    }

}
