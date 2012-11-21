<?php

class PaginationComponent implements ComponentSearchQueryInterface
{

    protected $_numberPerPage = 20;

    public function  __construct($numPerPage = null)
    {

        if ($numPerPage) {

            $this->_numberPerPage = $numPerPage;

        }

    }

    public function getNumberPerPage()
    {
        return $this->_numberPerPage;

    }

    public function setNumberPerPage($numberPerPage)
    {

        $this->_numberPerPage = $numberPerPage;

    }

    public function modify(SQLQuery $query, $data)
    {

        $query->limit($this->getLimit($data));

        return $query;

    }

    public function getLimit($data)
    {

        $start = isset($data['start']) ? (int) $data['start'] : 0;

        return $start . ', ' . (int) $this->_numberPerPage;

    }

}
