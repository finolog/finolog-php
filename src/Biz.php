<?php

namespace Finolog;

class Biz extends Api
{
    /**
     * @param array $payload
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(array $payload = []) {
        return $this->request('GET', 'biz/' . $payload['biz_id']);
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all() {
        return $this->request('GET', 'biz');
    }

    /**
     * @param array $payload
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add(array $payload = []) {
        return $this->request('POST', 'biz', $payload);
    }

    /**
     * @param array $payload
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(array $payload = []) {
        return $this->request('PUT', 'biz/' . $payload['biz_id'], $payload);
    }

    /**
     * @param array $payload
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(array $payload = []) {
        return $this->request('DELETE', 'biz/' . $payload['biz_id']);
    }
}
