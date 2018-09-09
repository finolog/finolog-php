<?php

use PHPUnit\Framework\TestCase;

use Finolog\Client;
use Finolog\Category;

final class CategoryTest extends TestCase
{

    /** @var int */
    protected static $bizID;

    /** @var Category */
    protected static $category;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static  function setUpBeforeClass() {
        $dotenv = new Dotenv\Dotenv(realpath(__DIR__ . '/..'));
        $dotenv->load();
        $client = new Client($_ENV['API_TOKEN']);
        self::$bizID = $client->biz->all()[0]->id;
        self::$category = $client->category;
    }

    /**
     * @test
     * @testdox Add new category
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add() {
        $category = self::$category->add(['biz_id' => self::$bizID, 'name' => 'category name', 'type' => 'in']);
        $this->assertEquals($category->name, 'category name');
        return $category;
    }

    /**
     * @test
     * @testdox Get category
     * @depends add
     * @param stdClass $category
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(stdClass $category) {
        $response = self::$category->get(['biz_id' => self::$bizID,'id' => $category->id]);
        $this->assertEquals($response->id, $category->id);
        return $response;
    }

    /**
     * @test
     * @testdox Get all categories
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all() {
        $category = self::$category->all(['biz_id' => self::$bizID]);
        $this->assertInternalType('array', $category);
    }

    /**
     * @test
     * @testdox Update category
     * @depends get
     * @param stdClass $category
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(stdClass $category) {
        $response = self::$category->update(['biz_id' => self::$bizID,'id' => $category->id, 'name' => 'new test category name']);
        $this->assertEquals($response->name, 'new test category name');
    }

    /**
     * @test
     * @testdox Delete category
     * @depends get
     * @param stdClass $category
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(stdClass $category) {
        $response = self::$category->delete(['biz_id' => self::$bizID, 'id' => $category->id]);
        $this->assertNotNull($response->deleted_at);
    }

}
