<?php

namespace Finolog;

class Category extends Api
{
    /** @var int  */
    private $biz_id;

    /**
     * Category constructor.
     * @param string $apiToken
     * @param int|null $biz_id
     */
    public function __construct(string $apiToken, int $biz_id = null) {
        parent::__construct($apiToken);
        $this->biz_id = $biz_id;
    }

    /**
     * @param array $payload
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(array $payload = []) {
        return $this->request('GET', 'biz/' . ($payload['biz_id'] ? $payload['biz_id'] : $this->biz_id). '/category/' . $payload['id']);
    }

    /**
     * @param array $payload
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all(array $payload = []) {
        return $this->request('GET', 'biz/' . ($payload['biz_id'] ? $payload['biz_id'] : $this->biz_id) . '/category');
    }

    /**
     * @param array $payload
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add(array $payload = []) {
        return $this->request('POST', 'biz/' . ($payload['biz_id'] ? $payload['biz_id'] : $this->biz_id) . '/category', $payload);
    }

    /**
     * @param array $payload
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(array $payload = []) {
        return $this->request('PUT', 'biz/' . ($payload['biz_id'] ? $payload['biz_id'] : $this->biz_id) . '/category/' . $payload['id'], $payload);
    }

    /**
     * @param array $payload
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(array $payload = []) {
        return $this->request('DELETE', 'biz/' . ($payload['biz_id'] ? $payload['biz_id'] : $this->biz_id) . '/category/' . $payload['id']);
    }
}
