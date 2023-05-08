<?php
namespace Eshchukina\TodoApi\Validator;
use Eshchukina\TodoApi\App\Validator;

class CompositeValidator implements Validator {

    private $validators;

    public function __construct() {
        $this->validators = [];
    }

    public function add(Validator $validator) {
        $this->validators[] = $validator;
    }

    public function isValid($value)
    {  
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($value)) {
                return false;
            }
        }
        return true;
    }
}
