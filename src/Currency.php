<?php

namespace Finolog;

class Currency extends Api
{
    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all() {
        return $this->request('GET', 'currency');
    }
}
