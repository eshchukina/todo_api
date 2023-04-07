<?php 
namespace Filter;
use App\Task;
use App\Comment;
use App\User;
use App\Filter;;


class UpperFilter implements Filter {
    public function isFilter($object) {

       if($object instanceof Task){ 
            $object->setTitle(ucfirst($object->getTitle()));
            $object->setDescription(ucfirst($object->getDescription()));
        } 

        elseif($object instanceof Comment) {
            $object->setMessage(ucfirst($object->getMessage()));
        }

        else {
            $object->setName(ucfirst($object->getName()));
            $object->setSurname(ucfirst($object->getSurname()));

        }

        return true;
            
      }
}


 


  

  