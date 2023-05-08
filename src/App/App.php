<?php

namespace App;

class App {

    private $storageTask; 
    private $storageComment;
    private $filter;
    private $commentFilter;
    private $userFilter;
    private $taskValidator;
    private $event;
    private $storageUser;

    public function __construct(TaskStorage $storageTask, 
                                CommentStorage $storageComment, 
                                Filter $filter, 
                                Filter $commentFilter,
                                Filter $userFilter,
                                Validator $taskValidator, 
                                Notificator $event, 
                                UserStorage $storageUser) {  

        $this->storageTask = $storageTask;
        $this->storageComment = $storageComment;
        $this->event = $event;
        $this->filter = $filter;
        $this->commentFilter = $commentFilter;
        $this->userFilter = $userFilter;
        $this->taskValidator = $taskValidator;
        $this->storageUser = $storageUser;

    }

    public function info(): array {
        return [
            'app' => 'todo',
        ];
    }
 
    public function addTask(Task $task) {
       
        
        $this->filter->filter($task);

        if (!$this->taskValidator->isValid($task)) {
            throw new \Exception('Invalid task (title)');
        }

        $this->storageTask->addTask($task);
        $this->event->notify($task, 'created');

        // if (!$this->event->notify($task, 'created')) {
        //     throw new \Exception('Invalid event storage (add)');
        // }
    }

    public function addComment(Comment $comment) {

        // if (!$this->commentFilter->filter($comment)) {
        //     throw new \Exception('Invalid addComent (filter)');
        // }
           $this->commentFilter->filter($comment);

        $this->storageComment->addComment($comment);

    }

    public function addUser(User $user) {    

        // if (!$this->filter->Filter($user)) {            
        //     throw new \Exception('Invalid addUser (filter)');
        // }
           $this->userFilter->filter($user);

        $this->storageUser->addUser($user);
 
    }

    public function getComment(int $task_id): array {

        return $this->storageComment->getComment($task_id);

   }
   public function getEvent(int $task_id): array {

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

        // if (!$this->filter->Filter($task)) {
        //     throw new \Exception('Invalid task (update title filter)');
        // }
           $this->filter->filter($task);

        if (!$this->taskValidator->isValid($task)) {
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