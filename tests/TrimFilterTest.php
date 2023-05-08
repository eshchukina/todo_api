<?php

namespace Filter\Tests;

use Filter\TrimFilter;
use App\Task;
use App\Comment;
use App\User;
use PHPUnit\Framework\TestCase;

class TrimFilterTest extends TestCase
{
    public function testFilterWithTask()
    {
        $filter = new TrimFilter();

        $task = new Task();
        $task->setTitle('  test title  ');
        $task->setDescription('  test description  ');

        $filter->Filter($task);

        $this->assertEquals('test title', $task->getTitle());
        $this->assertEquals('test description', $task->getDescription());
        echo "yes!\n";
    }

    public function testFilterWithComment()
    {
        $filter = new TrimFilter();

        $comment = new Comment();
        $comment->setMessage('  test message  ');

        $filter->Filter($comment);

        $this->assertEquals('test message', $comment->getMessage());
    }

    public function testFilterWithUser()
    {
        $filter = new TrimFilter();

        $user = new User();
        $user->setName('  test name  ');
        $user->setSurname('  test surname  ');

        $filter->Filter($user);

        $this->assertEquals('test name', $user->getName());
        $this->assertEquals('test surname', $user->getSurname());
        
    }

   
}
