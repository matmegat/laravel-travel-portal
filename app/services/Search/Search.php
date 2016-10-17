<?php

namespace services\Search;

abstract class Search
{
    abstract public function getCacheSection();

    abstract public function search(array $params);

    public function getFilters(array $input)
    {
        if (!empty($input['page']) && $input['page'] >= 0) {
            $filters['records-start'] = ($input['page'] - 1) * 10;
        } else {
            $filters['records-start'] = 0;
        }
        $filters['records-length'] = 10;
        $filters['all'] = !empty($input['keywords']) ? $input['keywords'] : '';

        if (!empty($input['cat'])) {
            $filters['productclass'] = $input['cat'];
        }
        if (!empty($input['country'])) {
            $filters['countries'] = $input['country'];
        }
        if (!empty($input['state'])) {
            $filters['states'] = $input['state'];
        }
        if (!empty($input['region'])) {
            $filters['regions'] = $input['region'];
        }

        return $filters;
    }
}
