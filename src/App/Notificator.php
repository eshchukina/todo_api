<?php

namespace App;

interface Notificator { 
    public function notify(Task $task, string $event);

}
