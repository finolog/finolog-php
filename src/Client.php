<?php

namespace Finolog;

class Client
{
    /** @var User  */
    public $user;

    /** @var Currency  */
    public $currency;

    /** @var Biz  */
    public $biz;

    /** @var Company  */
    public $company;

    /** @var Account  */
    public $account;

    /** @var Transaction  */
    public $transaction;

    /** @var Category  */
    public $category;

    /** @var Project  */
    public $project;

    /** @var Contractor  */
    public $contractor;

    /** @var Requisite  */
    public $requisite;

    /**
     * Client constructor.
     * @param string $apiToken
     * @param int|null $biz_id
     */
    public function __construct(string $apiToken, int $biz_id = null) {
        $this->user = new User($apiToken);
        $this->currency = new Currency($apiToken);
        $this->biz = new Biz($apiToken);
        $this->company = new Company($apiToken, $biz_id);
        $this->account = new Account($apiToken, $biz_id);
        $this->transaction = new Transaction($apiToken, $biz_id);
        $this->category = new Category($apiToken, $biz_id);
        $this->project = new Project($apiToken, $biz_id);
        $this->contractor = new Contractor($apiToken, $biz_id);
        $this->requisite = new Requisite($apiToken, $biz_id);
    }
}
