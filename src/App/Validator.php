<?php

namespace App;

interface Validator {
    public function isValid(Task $task);

}
