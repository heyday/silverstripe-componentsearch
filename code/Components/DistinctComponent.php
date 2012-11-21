<?php

class DistinctComponent implements ComponentSearchQueryInterface
{

    public function modify(SQLQuery $query, $data)
    {

        $query->distinct = true;

        return $query;

    }

}
