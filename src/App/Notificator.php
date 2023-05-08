<?php

namespace Eshchukina\TodoApi\App;

interface Notificator { 
    public function notify(Task $task, string $event);

}
