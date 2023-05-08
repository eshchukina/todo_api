<?php

namespace Eshchukina\TodoApi\Storage;
use Eshchukina\TodoApi\App;
use PDO;

class SqlUser implements App\UserStorage {
    private $pdo;

    public function __construct(PDO $pdo) {

        $this->pdo = $pdo;

    }

    public function addUser(App\User $user) //addEventLog or insert
    {
        $statement = $this->pdo->prepare("INSERT INTO user (name, surname, position) VALUES (:name, :surname, :position)");
        $statement->execute([
            'name'=> $user->getName(),
            'surname'=> $user->getSurname(),
            'position' => $user->getPosition(), 
        ]);
        
    }

   public function getUsers(): array {

        $statement = $this->pdo->prepare("SELECT * FROM user");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

   }

   public function getUser(int $id): App\User|null {

        $statement = $this->pdo->prepare("SELECT * FROM user WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute(); 
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($result[0])) {
            return App\User::fromArray($result[0]);
        }
        return null;

   }

   public function deleteUser(int $id) {

       $statement = $this->pdo->prepare("DELETE FROM user WHERE id = :id");
       $statement->bindParam(':id', $id);
       $statement->execute();

   }
     
}
