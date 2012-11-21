<?php

class ComponentSearchPaginationExtension extends Extension
{

    public function ComponentSearchPagination($template = 'ComponentSearchPagination')
    {
        return $this->owner->renderWith($template);

    }

    public function Subjects()
    {
        return $this->owner;

    }

    public function VirtualPages($num)
    {

        $pageNum = ceil($this->owner->TotalItems() / $num);

        $pages = new DataObjectSet();

        for ($i = 0; $i < $pageNum; $i++) {
            $page = new DataObject();
            $pages->push($page);
        }

        return $pages;

    }

}
