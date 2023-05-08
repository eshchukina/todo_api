<?php

namespace App;


 class Comment implements \JsonSerializable {
    private $id;
    private $task_id;
    private $author;
    private $message;
    private $date;

    public static function fromArray($arr) {

        $comment = new static();
        $comment->id = $arr['id'];
        $comment->task_id = $arr['task_id'];
        $comment->author = $arr['author'];
        $comment->message = $arr['message'];
        $comment->date = $arr['date'];

        return $comment;

    }
  
    public function getId() {

        return $this->id;

    }

    public function setId($id) {

        $this->id = $id;

    }

    public function getTaskId() {

        return $this->task_id;

    }

    public function setTaskId($task_id) {

        $this->task_id = $task_id;

    }

    public function getAuthor() {

        return $this->author;
    }

    public function setAuthor($author) {

        $this->author = $author;
    }

     public function getMessage() {

        return $this->message;

    }

    public function setMessage($message) {

        $this->message = $message;

    }

    public function getDate() {

        return $this->date;

    }

    public function setDate($date) {

        $this->date = $date;

    }

    function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'task_id' => $this->task_id,
            'author' => $this->author,
            'message' => $this->message,
            'date' => $this->date,
        ];
    }
    
}