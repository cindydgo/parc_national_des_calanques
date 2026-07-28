<?php

use Core\Database;

class TestUserRepository extends Database
{
    public function __construct()
    {
        parent::__construct('users');
    }

    public function createUser(array $data): int
    {
        $this->create($data);

        return (int) $this->getPdo()->lastInsertId();
    }


    public function getUser(int $id): ?array
    {
        return $this->readOne($id);
    }


    public function getUsers(array $filters = []): array
    {
        return $this->readAll($filters);
    }


    public function updateUser(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }


    public function deleteUser(int $id): bool
    {
        return $this->delete($id);
    }

    
    public function clearTable(): void
    {
        $this->getPdo()->exec("DELETE FROM users");
    }
}