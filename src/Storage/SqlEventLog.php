<?php

namespace Storage;
use App;
use PDO;

class SqlEventLog implements App\EventStorage {
    private $pdo;

    public function __construct(PDO $pdo) {

        $this->pdo = $pdo;

    }

    public function addNotify(App\Task $task, string $event) //addEventLog or insert 
    {
        $statement = $this->pdo->prepare("INSERT INTO event_log (task_id, user_id, event, date) VALUES (:task_id, :user_id, :event, :date)");
        $user_id = ($event == 'created') ? $task->getAuthorId() : $task->getExecutorId();
        $statement->execute([
            ':task_id'=> $task->getId(),
            ':user_id'=> $user_id,
            ':event' => $event,
            ':date' => date("Y-m-d H:i:s"),
        ]);

    }

    public function getNotify(App\Task $task, string $event) {
        
    } 
   
}
