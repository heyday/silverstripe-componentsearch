<?php
/**
 * Provides easy management and use of SQLQuery. Components are used to change a SQLQuery object and the the query can be performed.
 * Components are designed to be made as reusable units
 */
class ComponentSearch
{

    protected $_components = array();
    protected $_containerClass = 'DataObjectSet';
    protected $_baseClass = 'DataObject';
    protected $_data = array();

    public function getData()
    {
        return $this->_data;

    }

    public function setData($data, $clean = false)
    {

        $this->_data = $clean ? $data : Convert::raw2sql($data);

    }

    public function getContainerClass()
    {
        return $this->_containerClass;

    }

    public function setContainerClass($containerClass)
    {

        $this->_containerClass = $containerClass;

    }

    public function getBaseClass()
    {
        return $this->_baseClass;

    }

    public function setBaseClass($baseClass)
    {

        $this->_baseClass = $baseClass;

    }

    public function setComponents($components)
    {

        $this->_components = $components;

    }

    public function addComponent($component)
    {

        $this->_components[] = $component;

    }

    public function getComponents()
    {
        return $this->_components;

    }

    public function build()
    {

        $query = new SQLQuery();

        if (is_array($this->_components)) {

            foreach ($this->_components as $component) {

                if ($component instanceof ComponentSearchQueryInterface) $query = $component->modify($query, $this->_data);

            }

        }

        return $query;

    }

    public function run()
    {

        $query = $this->build();

        $results = singleton('DataObject')->buildDataObjectSet(
            $query->execute(),
            $this->_containerClass,
            $query,
            $this->_baseClass
        );

        if ($results instanceof $this->_containerClass) {

            $results->parseQueryLimit($query);

        }

        return $results;

    }

}
