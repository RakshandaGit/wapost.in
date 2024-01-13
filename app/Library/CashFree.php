<?php

namespace App\Library;

class CashFree
{
    protected $params      = [];
    protected $_url;
    protected $environment = 'sandbox';

    function __construct($environment)
    {
        $this->environment = $environment;
        if ($this->environment == 'sandbox') {
            $this->_url = 'https://sandbox.cashfree.com/pg';
        } else {
            $this->_url = 'https://api.cashfree.com/pg';
        }
        $this->param('service_provider', 'cashfree');
    }

    public function param($param, $value)
    {
        $this->params["$param"] = $value;
    }
}
