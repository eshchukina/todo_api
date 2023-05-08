<?php

namespace Eshchukina\TodoApi\Storage;
use Eshchukina\TodoApi\App;
use PDO;

class SqlEventLog implements App\EventStorage {
    private $pdo;

    public function __construct(PDO $pdo) {

        $this->pdo = $pdo;

    }

    public function addNotify(App\Task $task, string $event) //addEventLog or insert 
    {
        $statement = $this->pdo->prepare("INSERT INTO event_log (task_id, assignee, event, date) VALUES (:task_id, :assignee, :event, :date)");
        $assignee = ($event == 'created') ? $task->getAuthor() : $task->getAssignee();
        $statement->execute([
            ':task_id'=> $task->getId(),
            ':assignee'=> $assignee,
            ':event' => $event,
            ':date' => date("Y-m-d H:i:s"),
        ]);

    }

    
    
   
}
