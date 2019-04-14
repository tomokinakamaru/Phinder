<?php

namespace Phinder\Pattern\Node;

use Phinder\Pattern\Node;

class KeyValuePair extends Node
{
    private $_key;

    private $_value;

    public function __construct($key, $value)
    {
        $this->_key = $key;
        $this->_value = $value;
    }

    protected function matchPhpNode($phpNode)
    {
        return true;
    }

    protected function getChildrenArray()
    {
        return [
            $this->_key->toArray(),
            $this->_value->toArray(),
        ];
    }
}
