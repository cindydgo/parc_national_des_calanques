<?php
namespace App\Controllers;

use App\Models\UserModel;
use Core\ApiResponse;

final class UsersController
{
    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    /**
     * GET /api/users
     * Get all users with optional filters
     * @param array $filters Filters to apply
     * @return void
     */
    public function index(array $filters = []): void
    {
        unset($filters['resource']);
        $users = $this->model->getUsers($filters);
        ApiResponse::success('Liste des utilisateurs récupérée', $users, 200);
    }

    /**
     * GET /api/users/{id}
     * Get a single user by ID
     * @param int $id User ID
     * @return void
     */
    public function show(int $id): void
    {
        $user = $this->model->getUser($id);
        ApiResponse::success("Utilisateur trouvé", $user, 200);
    }

    /**
     * POST /api/users
     * Create a new user
     * @param array $data User data
     * @return void
     */
    public function store(array $data): void
    {
        $created = $this->model->createUser($data);

        if ($created) {
            ApiResponse::success("Utilisateur créé avec succès", $data, 201);
        } else {
            ApiResponse::error("Erreur lors de la création de l'utilisateur", [], 500);
        }
    }

    /**
     * PUT /api/users/{id}
     * Update an existing user
     * @param int $id User ID
     * @param array $data User data
     * @return void
     */
    public function update(int $id, array $data): void
    {
        $updated = $this->model->updateUser($id, $data);

        if ($updated) {
            ApiResponse::success("Utilisateur mis à jour avec succès", $data, 200);
        } else {
            ApiResponse::error("Erreur lors de la mise à jour de l'utilisateur", [], 500);
        }
    }

    /**
     * DELETE /api/users/{id}
     * Delete a user by ID
     * @param int $id User ID
     * @return void
     */
    public function delete(int $id): void
    {
        $deleted = $this->model->deleteUser($id);

        if ($deleted) {
            ApiResponse::success("Utilisateur supprimé avec succès", [], 200);
        } else {
            ApiResponse::error("Erreur lors de la suppression de l'utilisateur", [], 500);
        }
    }
}
