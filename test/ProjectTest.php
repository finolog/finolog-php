<?php

use PHPUnit\Framework\TestCase;

use Finolog\Client;
use Finolog\Project;

final class ProjectTest extends TestCase
{

    /** @var int */
    protected static $bizID;

    /** @var Project */
    protected static $project;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static  function setUpBeforeClass() {
        $dotenv = new Dotenv\Dotenv(realpath(__DIR__ . '/..'));
        $dotenv->load();
        $client = new Client($_ENV['API_TOKEN']);
        self::$bizID = $client->biz->all()[0]->id;
        self::$project = $client->project;
    }

    /**
     * @test
     * @testdox Add new project
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add() {
        $project = self::$project->add(['biz_id' => self::$bizID, 'name' => 'project name', 'currency_id' => 1]);
        $this->assertEquals($project->name, 'project name');
        return $project;
    }

    /**
     * @test
     * @testdox Get project
     * @depends add
     * @param stdClass $project
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(stdClass $project) {
        $response = self::$project->get(['biz_id' => self::$bizID,'id' => $project->id]);
        $this->assertEquals($response->id, $project->id);
        return $response;
    }

    /**
     * @test
     * @testdox Get all projects
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all() {
        $project = self::$project->all(['biz_id' => self::$bizID]);
        $this->assertInternalType('array', $project);
    }

    /**
     * @test
     * @testdox Update project
     * @depends get
     * @param stdClass $project
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(stdClass $project) {
        $response = self::$project->update(['biz_id' => self::$bizID,'id' => $project->id, 'name' => 'new test project name']);
        $this->assertEquals($response->name, 'new test project name');
    }

    /**
     * @test
     * @testdox Delete project
     * @depends get
     * @param stdClass $project
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(stdClass $project) {
        $response = self::$project->delete(['biz_id' => self::$bizID, 'id' => $project->id]);
        $this->assertNotNull($response->deleted_at);
    }

}
