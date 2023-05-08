<?php

namespace Eshchukina\TodoApi\App;

interface CommentStorage  {
    public function addComment(Comment $comment); 
     public function getComment(int $task_id): array;
    
}