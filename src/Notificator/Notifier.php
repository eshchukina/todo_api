<?php 
namespace Eshchukina\TodoApi\Notificator;
use Eshchukina\TodoApi\App\Notificator;

class Notifier implements Notificator {   
    private $eventStorage;
    
    public function __construct(\Eshchukina\TodoApi\App\EventStorage $eventStorage) {
        $this->eventStorage = $eventStorage;
    }

    public function notify(\Eshchukina\TodoApi\App\Task $task, string $event) {
        
        return $this->eventStorage->addNotify($task, $event);
    }
}

