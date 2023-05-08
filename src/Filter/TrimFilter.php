<?php 
namespace Filter;
use App\Task;
use App\Comment;
use App\User;
use App\Filter;

class TrimFilter implements Filter {

    public function filter($value) {
        return preg_replace('/\s+/', ' ', trim($value));
    }
}
    