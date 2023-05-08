<?php

namespace Eshchukina\TodoApi\App;

 class User implements \JsonSerializable {
    private $id;
    private $name;
    private $surname;
    private $position;
    
    public static function fromArray($arr) {

        $user = new static();
        $user->id = $arr['id'];
        $user->name = $arr['name'];
        $user->surname = $arr['surname'];
        $user->position = $arr['position'];
      
        return $user;
    }
   
    public function getId() {

        return $this->id;

    }

    public function setId($id) {

        $this->id = $id;
        
    }

    public function getName() {

        return $this->name;

    }

    public function setName($name) {

        $this->name = $name;

    }

    public function getSurname() {

        return $this->surname;

    }

    public function setSurname($surname) {

        $this->surname = $surname;

    }

    public function getPosition() {

        return $this->position;

    }

    public function setPosition($position) {

        $this->position = $position;

    }

    function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'position' => $this->position,
        ];
    }
    
}