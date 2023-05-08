<?php

namespace Eshchukina\TodoApi\App;

interface UserStorage {
    public function addUser(User $user);
    public function getUsers(): array;
    public function getUser(int $id): User|null;
    public function deleteUser(int $id);
}
