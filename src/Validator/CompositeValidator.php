<?php
namespace Validator;
use App\Validator;

class CompositeValidator implements Validator {

    private $validators;

    public function __construct() {
        $this->validators = [];
    }

    public function add(Validator $validator) {
        $this->validators[] = $validator;
    }

    public function isValid(\App\Task $task)
    {  
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($task)) {
                return false;
            }
        }
        return true;
    }
}
