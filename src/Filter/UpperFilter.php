<?php 
namespace Eshchukina\TodoApi\Filter;
use App\Task;
use App\Comment;
use App\User;
use Eshchukina\TodoApi\App\Filter;;


class UpperFilter implements Filter {

    public function filter($value) {
        return ucfirst($value);
    }
}
  