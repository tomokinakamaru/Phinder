<?php

namespace Phinder\PatternParser\Node;

use Phinder\PatternParser\Node;

class BooleanLiteral extends Node
{
    private $_value;

    public function __construct($value = null)
    {
        $this->_value = $value;
    }

    public function match($phpNode)
    {
        return true;
    }
}
