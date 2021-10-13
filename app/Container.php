<?php

namespace App;
class Container
{
    protected $binding = [];
    public function bind($key,$service)
    {
        $this->binding[$key] = $service;
    }

    public function resolve($key)
    {
        if(isset($this->binding[$key])){
            return call_user_func($this->binding[$key]);
        }
    }
}
