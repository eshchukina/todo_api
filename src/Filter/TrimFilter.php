<?php 
namespace Filter;
use App\Task;
use App\Comment;
use App\User;
use App\Filter;

class TrimFilter implements Filter {

    public function isFilter($object) {   

        if ($object instanceof Task) {
            $object->setTitle(preg_replace('/\s+/', ' ', trim($object->getTitle())));
            $object->setDescription(preg_replace('/\s+/', ' ', trim($object->getDescription())));
        } elseif ($object instanceof Comment) {
             $object->setMessage(preg_replace('/\s+/', ' ', trim($object->getMessage())));
        } else {

            $object->setName(preg_replace('/\s+/', ' ', trim($object->getName())));
            $object->setSurname(preg_replace('/\s+/', ' ', trim($object->getSurname())));


        }

        return true;
    }
}
    







     
      