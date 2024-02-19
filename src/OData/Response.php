<?php

namespace Tools1C\OData;

use Psr\Http\Message\ResponseInterface;

class Response
{
    protected $response;
    protected $clnt;

    private $arr;

    public function __construct(Client $clnt, ResponseInterface $resp) {
        $this->clnt = $clnt;
        $this->response = $resp;
    }

    public function __toString() {
        return $this->response->getBody();
    }

    public function toArray() {
        if(!$this->arr)
            $this->arr = json_decode($this->response->getBody(),true);
        return $this->arr;
    }

    public function values() {
        $arr = $this->toArray();
        return isset($arr['value']) ? $arr['value'] : (isset($arr['Ref_Key']) ? [$arr] : []);
    }

    public function first() {
        $vals = $this->values();
        return isset($vals[0]) ? $vals[0] : null;
    }

}
