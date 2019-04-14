<?php

namespace Phinder\Pattern\Node;

use Phinder\Pattern\Node;

class Conjunction extends Node
{
    private $_patternNode1;

    private $_patternNode2;

    public function __construct($patternNode1, $patternNode2)
    {
        $this->_patternNode1 = $patternNode1;
        $this->_patternNode2 = $patternNode2;
    }

    protected function matchPhpNode($phpNode)
    {
        return $this->_patternNode1->match($phpNode)
        && $this->_patternNode2->match($phpNode);
    }

    protected function getChildrenArray()
    {
        return [
            $this->_patternNode1->toArray(),
            $this->_patternNode2->toArray(),
        ];
    }
}
