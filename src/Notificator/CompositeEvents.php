<?php
namespace Eshchukina\TodoApi\Notificator;
use Eshchukina\TodoApi\App\Notificator;

class CompositeEvents implements Notificator {
    private $events;

    public function __construct() {
        $this->events = [];
    }

    public function add(Notificator $event) {
        $this->events[] = $event;
    }

    public function notify(\Eshchukina\TodoApi\App\Task $task, string $event) {
        
        foreach ($this->events as $enent) {
            $enent->notify($task, $event);

        }

    }
}