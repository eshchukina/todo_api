<?php

namespace Storage;
use App;
use PDO;

class SqlTask implements App\TaskStorage {
    private $pdo;

    public function __construct(PDO $pdo) {

        $this->pdo = $pdo;
    }

    public function addTask(App\Task $task) {

        $statement = $this->pdo->prepare("INSERT INTO task (title, description, status, author, assignee, end_time) VALUES (:title, :description, :status, :author, :assignee, :end_time)");
        $statement->execute([
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'status' => $task->getStatus(),
            'author' => $task->getAuthor(),
            'assignee' => $task->getAssignee(),
            //'start_time' => date("Y-m-d H:i:s"),
            'end_time' => null,

        
        ]);

        $task->setId($this->pdo->lastInsertId());
    }

    public function getTasks(): array {

        $statement = $this->pdo->prepare("SELECT * FROM task");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTask(int $id): App\Task|null {

        $statement = $this->pdo->prepare("SELECT * FROM task WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute(); 
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($result[0])) {
            return App\Task::fromArray($result[0]);
        }
        return null;
    }

    public function deleteTask(int $id) {

        $statement = $this->pdo->prepare("DELETE FROM task WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();
    }

    public function updateTask(App\Task $task) {

        if ($task->getStatus() == 'done') {
             $task->setEndTime(date("Y-m-d H:i:s"));
        }

        if (!$task->getId()) {
            throw new \UnexpectedValueException("cannot update task");
        }

        $statement = $this->pdo->prepare("UPDATE task SET title = :title, description = :description, status = :status, author = :author, assignee = :assignee, end_time =:end_time WHERE id = :id");
        $statement->execute([
            'id' => $task->getId(), 
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'status' => $task->getStatus(),
            'author' => $task->getAuthor(),
            'assignee' => $task->getAssignee(),
            'end_time' => date("Y-m-d H:i:s"),
           

        ]);
    }
}
