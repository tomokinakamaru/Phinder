<?php

namespace Phinder\PatternParser\Node;

use Phinder\PatternParser\Node;

class Arguments extends Node
{
    private $_head;

    private $_tail;

    public function __construct($head = null, $tail = null)
    {
        $this->_head = $head;
        $this->_tail = $tail;
    }

    public function match($phpNode)
    {
        return true;
    }
}
