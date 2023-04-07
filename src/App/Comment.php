<?php

namespace App;


 class Comment implements \JsonSerializable {
    private $id;
    private $task_id;
    private $user_id;
    private $message;
    private $date;

    public static function fromArray($arr) {

        $comment = new static();
        $comment->id = $arr['id'];
        $comment->task_id = $arr['task_id'];
        $comment->user_id = $arr['user_id'];
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

    public function getUserId() {

        return $this->user_id;
    }

    public function setUserId($user_id) {

        $this->user_id = $user_id;
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
            'user_id' => $this->user_id,
            'message' => $this->message,
            'date' => $this->date,
        ];
    }
    
}