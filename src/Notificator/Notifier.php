<?php 
namespace Notificator;
use App\Notificator;

class Notifier implements Notificator {   
    private $eventStorage;
    
    public function __construct(\App\EventStorage $eventStorage) {
        $this->eventStorage = $eventStorage;
    }

    public function notify(\App\Task $task, string $event) {
        
        return $this->eventStorage->addNotify($task, $event);
    }
}

