<?php

use PHPUnit\Framework\TestCase;

use Finolog\Client;
use Finolog\Transaction;

final class TransactionTest extends TestCase
{

    /** @var int */
    protected static $bizID;

    /** @var int */
    protected static $accountID;

    /** @var Transaction */
    protected static $transaction;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static  function setUpBeforeClass() {
        $dotenv = new Dotenv\Dotenv(realpath(__DIR__ . '/..'));
        $dotenv->load();
        $client = new Client($_ENV['API_TOKEN']);
        self::$bizID = $client->biz->all()[0]->id;
        self::$accountID = $client->account->all(['biz_id' => self::$bizID])[0]->id;
        self::$transaction = $client->transaction;
    }

    /**
     * @test
     * @testdox Add new transaction
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add() {
        $transaction = self::$transaction->add([
            'biz_id' => self::$bizID,
            'to_id' => self::$accountID,
            'date' => '2018-01-01',
            'value' => 1000
        ]);
        $this->assertEquals($transaction->value, 1000);
        return $transaction;
    }

    /**
     * @test
     * @testdox Get transaction
     * @depends add
     * @param stdClass $transaction
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(stdClass $transaction) {
        $response = self::$transaction->get(['biz_id' => self::$bizID,'id' => $transaction->id]);
        $this->assertEquals($response->id, $transaction->id);
        return $response;
    }

    /**
     * @test
     * @testdox Get all transactions
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all() {
        $transaction = self::$transaction->all(['biz_id' => self::$bizID]);
        $this->assertInternalType('array', $transaction);
    }

    /**
     * @test
     * @testdox Update transaction
     * @depends get
     * @param stdClass $transaction
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(stdClass $transaction) {
        $response = self::$transaction->update(['biz_id' => self::$bizID,'id' => $transaction->id, 'value' => 2000]);
        $this->assertEquals($response->value, 2000);
        return $response;
    }

    /**
     * @test
     * @testdox Split transaction
     * @depends update
     * @param stdClass $transaction
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function split(stdClass $transaction) {
        $response = self::$transaction->split([
            'biz_id' => self::$bizID,
            'id' => $transaction->id,
            'items' => [
                [ 'value' => $transaction->value - 200 ],
                [ 'value' => 200 ]
            ]
        ]);
        $this->assertInternalType('array', $response);
        return $response;
    }

    /**
     * @test
     * @testdox Cancel split transaction
     * @depends split
     * @param array $transaction
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancel(array $transaction) {
        $response = self::$transaction->cancel(['biz_id' => self::$bizID, 'id' => $transaction[0]->split_id]);
        $this->assertInternalType('array', $response->deleted_ids);
        return $response;
    }

    /**
     * @test
     * @testdox Delete transaction
     * @depends get
     * @param stdClass $transaction
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(stdClass $transaction) {
        $response = self::$transaction->delete(['biz_id' => self::$bizID, 'id' => $transaction->id]);
        $this->assertTrue($response->success);
    }

}
