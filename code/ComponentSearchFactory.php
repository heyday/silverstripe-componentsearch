<?php
/**
 * Factory class for ComponentSearch, provides easy searching
 */
class ComponentSearchFactory
{
        /**
         * Used for general search
         * @param array $components
         * @param array $data
         * @param boolean $clean
         * @return ComponentSearch
         */
    public static function search($components, $data, $clean = false)
    {

        $search = new ComponentSearch();

        $search->setComponents(is_array($components) ? $components : array($components));
        $search->setData($data, $clean);

        return $search;

    }

    /**
     * Warning this function is likely slow.
     * @param  array         $componentSets
     * @param  arrat         $data
     * @param  int           $pageLength
     * @return DataObjectSet
     */
    public static function search_union($componentSets, $data, PaginationComponent $paginationComponent = null, $orderby = null)
    {

        $parts = array();

        $data = Convert::raw2sql($data);

        $extra = '';

        $DOS = false;

        $pagination = $paginationComponent instanceof PaginationComponent;

        foreach ($componentSets as $index => $componentSet) {

            $query = self::search($componentSet, $data, true)->build();

            if ($index == 0 && $pagination) {

                $query->replaceText('SELECT', 'SELECT SQL_CALC_FOUND_ROWS');

            }

            $parts[] = $query->sql();

        }

        if ($orderby) {
            $extra .= " ORDER BY $orderby";
        }

        if ($pagination) {

            $extra .= ' LIMIT ' . $paginationComponent->getLimit($data);

        }

        $records = DB::query('(' . implode(') UNION (', $parts) . ')' . $extra);

        if ($pagination) {

            $totalResult = DB::query('SELECT FOUND_ROWS() as TotalItems')->nextRecord();
            $totalItems = isset($totalResult['TotalItems']) ? $totalResult['TotalItems'] : false;

        }

        foreach ($records as $record) {

            if (isset($record['ClassName']) && isset($record['ID'])) {

                $results[] = DataObject::get_by_id($record['ClassName'], $record['ID']);

            }

        }

        if (isset($results)) {

            $DOS = new DataObjectSet($results);

            if ($pagination) {

                $DOS->setPageLimits(
                    isset($data['start']) ? $data['start'] : 0,
                    $paginationComponent->getNumberPerPage(),
                    $totalItems ? $totalItems : $DOS->TotalItems()
                );

            }

        }

        return $DOS;

    }

}
