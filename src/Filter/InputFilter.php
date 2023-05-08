<?php

namespace Filter;

use App\Filter;

class InputFilter implements Filter
{
    private $filters = [];

    public function filter($object)
    {
        $arr = json_decode(json_encode($object), true);
        $filteredValues = [];

        foreach ($this->filters as $field => $filters) {
            if (empty($arr[$field])) {
                continue;
            }

            $val = $arr[$field];

            foreach ($filters as $filter) {
                $val = $filter->filter($val);
            }

            $filteredValues[$field] = $val;
        }

        foreach ($filteredValues as $field => $value) {
            $method = 'set' . ucfirst($field);

            if (method_exists($object, $method)) {
                $object->$method($value);
            }
        }
    }

    public function add(string $field, array $filters)
    {
        foreach ($filters as $filter) {
            $this->filters[$field][] = $filter;
        }
    }
}
