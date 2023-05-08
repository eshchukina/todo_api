<?php
namespace Eshchukina\TodoApi\Filter;
use Eshchukina\TodoApi\App\Filter;

class CompositeFilter implements Filter {
    private $filters;

    public function __construct() {
        $this->filters = [];
    }

    public function add(Filter $filter) {
        $this->filters[] = $filter;
    }

    public function Filter($object) {

        foreach ($this->filters as $filter) {
            if (!$filter->Filter($object)) {
                return false;
            }
        }

        return true;
        
    }
}
    
    
    
    
    
    
