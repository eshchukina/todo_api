<?php

namespace App;

class App {

    private $storageTask; 
    private $storageComment;
    private $filter;
    private $validator;
    private $event;
    private $storageUser;

    public function __construct(TaskStorage $storageTask, 
                                CommentStorage $storageComment, 
                                Filter $filter, 
                                Validator $validator, 
                                Notificator $event, 
                                UserStorage $storageUser) {  

        $this->storageTask = $storageTask;
        $this->storageComment = $storageComment;
        $this->event = $event;
        $this->filter = $filter;
        $this->validator = $validator;
        $this->storageUser = $storageUser;

    }

    public function info(): array {
        return [
            'app' => 'todo',
        ];
    }
 
    public function addTask(Task $task) {
       
        if (!$this->filter->isFilter($task)) {
            throw new \Exception('Invalid task (add title filter)');
        }
           $this->filter->isFilter($task);

        if (!$this->validator->isValid($task)) {
            throw new \Exception('Invalid task (title)');
        }

        $this->storageTask->addTask($task);
        $this->event->notify($task, 'created');

        // if (!$this->event->notify($task, 'created')) {
        //     throw new \Exception('Invalid event storage (add)');
        // }
    }

    public function addComment(Comment $comment) {

        if (!$this->filter->isFilter($comment)) {
            throw new \Exception('Invalid addComent (filter)');
        }
           $this->filter->isFilter($comment);

        $this->storageComment->addComment($comment);

    }

    public function addUser(User $user) {    

        if (!$this->filter->isFilter($user)) {            
            throw new \Exception('Invalid addUser (filter)');
        }
           $this->filter->isFilter($user);

        $this->storageUser->addUser($user);
 
    }

    public function getComment(int $task_id): array {

        return $this->storageComment->getComment($task_id);

   }

    public function getTasks(): array {

        return $this->storageTask->getTasks();

    } 

    public function getUsers(): array {

        return $this->storageUser->getUsers();

    } 

    public function getTask(int $id): Task|null {

        return $this->storageTask->getTask($id);

    }

    public function getUser(int $id): User|null {

        return $this->storageUser->getUser($id);

    }

    public function updateTask(Task $task) {   

        if (!$this->filter->isFilter($task)) {
            throw new \Exception('Invalid task (update title filter)');
        }
           $this->filter->isFilter($task);

        if (!$this->validator->isValid($task)) {
            throw new \Exception('Invalid task (description)');
        }

         $this->storageTask->updateTask($task);
         $this->event->notify($task, 'updated');
    }

    public function deleteTask(int $id) {

        //$this->storage->deleteTask($id);
        //$this->event->notify($task, 'delete');
        $task = $this->storageTask->getTask($id); 
        $this->storageTask->deleteTask($id);
        $this->event->notify($task, 'deleted');

    }

    public function deleteUser(int $id) {
       
        $user = $this->storageUser->getUser($id); // get the task before it's deleted
        $this->storageUser->deleteUser($id);
    
    }
}