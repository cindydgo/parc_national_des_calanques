<?php
namespace App\Models;

use Core\Model;

final class UserModel extends Model
{
    public function __construct()
    {
        parent::__construct('users');
    }

    /**
     * Get all users with optional filters
     * @param array $data Filters to apply
     * @return array
     */
    public function getUsers(array $filters = []): array
    {
        $users = $this->all($filters);

        return $users;
    }


    /**
     * Get a single user by ID
     * @param int $id User ID
     * @return array|null
     */
    public function getUser(int $id): ?array
    {
        $user = $this->find($id);

        return $user;
    }

    /**
     * Get a user by username or email
     * @param string $username
     * @return array|null
     */
    public function getUserByUsernameOrEmail(string $username, string $email): ?array
    {
        $query = "
            SELECT *
            FROM {$this->tableName}
            WHERE username = :username OR email = :email
            LIMIT 1
        ";

        $this->sqlQuery($query, ['username' => $username, 'email' => $email]);

        $result = $this->stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ?: null;
    }


    /**
     * Create a new user and return its ID
     * @param array $data User data
     * @return int|false
     */
    public function createUser(array $data): int|false
    {
        $created = $this->create($data);
        if (!$created) {
            return false;
        }

        return (int)$this->getPdo()->lastInsertId();
    }

    /**
     * Check if a user already exists by username or email
     * @param string $username
     * @param string $email
     * @return bool
     */
    public function isUserAlreadyExist(string $username, string $email): bool
    {
        $query = "
                SELECT COUNT(*)     
                FROM {$this->tableName} 
                WHERE username = :username OR email = :email
            ";

        $this->sqlQuery($query, ['username' => $username, 'email' => $email]);

        $count = $this->stmt->fetchColumn();

        return $count > 0;
    }


    /**
     * Update an existing user
     * @param int $id User ID
     * @param array $data User data
     * @return bool
     */
    public function updateUser(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    /**
     * Delete a user by ID
     * @param int $id User ID
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        return $this->delete($id);
    }
}
