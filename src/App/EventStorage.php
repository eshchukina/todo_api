<?php

namespace Eshchukina\TodoApi\App;

interface EventStorage {
    public function addNotify(Task $task, string $event); 
     //public function getNotify(int $id): \App\Task|null;
    

}
