<?php 
// namespace Validator;
// use App\Validator;

// class DescriptionLenght implements Validator {

    
//     public function isValid(\App\Task $task): bool {
//         //(count($task->getTitle()) < 5)
//         if ((strlen($task->getDescription()) < 20) || (strlen($task->getDescription()) > 200)) {
//             return false;
//         }
//         return true;
//     }
// }

namespace Validator;
use App\Validator;

class LenghtValidator implements Validator {
    private $minLength;
    private $maxLength;

    public function __construct($minLength, $maxLength) {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    public function isValid($value): bool {
        if ((strlen($value) < $this->minLength) || (strlen($value) > $this->maxLength)) {
            return false;
        }
        
        return true;
    }
}
