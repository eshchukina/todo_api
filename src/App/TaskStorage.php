<?php

namespace App;

interface TaskStorage {
    public function addTask(Task $task);
    public function getTasks(): array;
    public function getTask(int $id): Task|null;
    public function updateTask(Task $task);
    public function deleteTask(int $id);
}
