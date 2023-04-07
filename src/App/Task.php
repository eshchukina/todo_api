<?php

namespace App;


 class Task implements \JsonSerializable {
    private $id;
    private $title;
    private $description;
    private $status;
    private $author_id; //author
    private $executor_id; //assignee
    private $start_time;
    private $end_time;

    public static function fromArray($arr) {

        $task = new static();
        $task->id = $arr['id'];
        $task->title = $arr['title'];
        $task->description = $arr['description'];
        $task->author_id = $arr['author_id'];
        $task->executor_id = $arr['executor_id'];
        $task->status = $arr['status'];
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

    public function getEndTime() {

        return $this->end_time;
    }

    public function setEndTime($end_time) {

        $this->end_time = $end_time;

    }

    public function getAuthorId() {

        return $this->author_id;

    }

    public function setAuthorId($author_id) {

        $this->author_id = $author_id;

    }

    public function getExecutorId() {

        return $this->executor_id;

    }
   
    public function setExecutorId($executor_id) {

        $this->executor_id = $executor_id;

    }

    function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author_id' => $this->author_id,
            'executor_id' => $this->executor_id,
            'description' => $this->description,
            'start_time' => $this->start_time, 
            'end_time' => $this->end_time,
        ];
    }
    
}

