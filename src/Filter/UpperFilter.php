<?php 
namespace Filter;
use App\Task;
use App\Comment;
use App\User;
use App\Filter;;


class UpperFilter implements Filter {

    public function filter($value) {
        return ucfirst($value);
    }
}
  