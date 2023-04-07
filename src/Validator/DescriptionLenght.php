<?php 
namespace Validator;
use App\Validator;

class DescriptionLenght implements Validator {
    public function isValid(\App\Task $task): bool {
        //(count($task->getTitle()) < 5)
        if ((strlen($task->getDescription()) < 20) || (strlen($task->getDescription()) > 200)) {
            return false;
        }
        return true;
    }
}