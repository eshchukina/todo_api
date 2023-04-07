<?php 
namespace Validator;
use App\Validator;

class TitleLenght implements Validator {
    public function isValid(\App\Task $task): bool {
        if ((strlen($task->getTitle()) < 5) || (strlen($task->getTitle()) > 60)) {
            return false;
        }
        
        return true;
    }
}