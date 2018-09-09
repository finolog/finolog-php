<?php

namespace Finolog;

class User extends Api
{
    /**
     * Get authorized user.
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get() {
        return $this->request('GET', 'user');
    }

    /**
     * Update authorized user.
     * @param array $payload
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(array $payload = []) {
        return $this->request('PUT', 'user', $payload);
    }
}
