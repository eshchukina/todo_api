<?php

namespace Eshchukina\TodoApi\App;


 class Task implements \JsonSerializable {
    private $id;
    private $title;
    private $description;
    private $status;
    private $author; //author
    private $assignee; //assignee
    private $start_time;
    private $end_time;

    public static function fromArray($arr) {

        $task = new static();
        $task->id = $arr['id'];
        $task->title = $arr['title'];
        $task->description = $arr['description'];
        $task->status = $arr['status'];
        $task->author = $arr['author'];
        $task->assignee = $arr['assignee'];
        $task->start_time = $arr['start_time'];
        $task->end_time = $arr['end_time'];

        return $task;
    }
   
    public function getId() {

        return $this->id;

    }
   
    public function setId($id) {

        $this->id = $id;

    }

    public function getTitle() {

        return $this->title;

    }


    public function setTitle($title)
    {
        $this->title = $title;
    }

   
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description) {

        $this->description = $description;

    }

    public function getStatus() {

        return $this->status;

    }
   
    public function setStatus($status) {

        $this->status = $status;

    }

    public function getAuthor() {

       return $this->author;

    }
    public function setAuthor($author) {

        $this->author = $author;

    }
   
    public function getAssignee() {

        return $this->assignee;
 
     }
     public function setAssignee($assignee) {
 
         $this->assignee = $assignee;
 
     }
    
 

     public function getStartTime() {

        return $this->start_time;
    }

    public function setStartTime($start_time) {

        $this->start_time = $start_time;

    }

    public function getEndTime() {

        return $this->end_time;
    }

    public function setEndTime($end_time) {

        $this->end_time = $end_time;

    }

   

    

    function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'author' => $this->author,
            'assignee' => $this->assignee,
            'start_time' => $this->start_time, 
            'end_time' => $this->end_time,
        ];
    }
    
}

