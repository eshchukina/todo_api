<?php

namespace Storage;
use App;
use PDO;

class SqlComment implements App\CommentStorage {
    private $pdo;

    public function __construct(PDO $pdo) {

        $this->pdo = $pdo;
    }

    public function addComment(App\Comment $comment) {

        $statement = $this->pdo->prepare("INSERT INTO comment (task_id, author, message, date) VALUES (:task_id, :author, :message, :date)");
        $statement->execute([
            'task_id'=> $comment->getTaskId(),
            'author'=> $comment->getAuthor(),
            'message'=> $comment->getMessage(),
            'date' => date("Y-m-d H:i:s"),
        ]);
        $comment->setId($this->pdo->lastInsertId());
        
    }
   
    public function getComment(int $task_id): array {
        
        $statement = $this->pdo->prepare("SELECT * FROM comment WHERE task_id = :task_id");
        $statement->bindParam(':task_id', $task_id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    } 

}
