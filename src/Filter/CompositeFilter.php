<?php
namespace Filter;
use App\Filter;

class CompositeFilter implements Filter {
    private $filters;

    public function __construct() {
        $this->filters = [];
    }

    public function add(Filter $filter) {
        $this->filters[] = $filter;
    }

    public function isFilter($object) {

        foreach ($this->filters as $filter) {
            if (!$filter->isFilter($object)) {
                return false;
            }
        }

        return true;
        
    }
}
    
    
    
    
    
    
