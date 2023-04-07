<?php
namespace Notificator;
use App\Notificator;

class CompositeEvents implements Notificator {
    private $events;

    public function __construct() {
        $this->events = [];
    }

    public function add(Notificator $event) {
        $this->events[] = $event;
    }

    public function notify(\App\Task $task, string $event) {
        
        foreach ($this->events as $enent) {
            $enent->notify($task, $event);

        }

    }
}