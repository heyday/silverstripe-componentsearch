<?php

class LimitComponent implements ComponentSearchQueryInterface
{

    protected $_limit;

    public function  __construct($limit = false)
    {

        $this->_limit = $limit;

    }

    public function getLimit()
    {
        return $this->_limit;

    }

    public function setLimit($limit)
    {

        $this->_limit = $limit;

    }

    public function modify(SQLQuery $query, $data)
    {

        if ($this->_limit) {

            $query->limit($this->_limit);

        }

        return $query;

    }

}
