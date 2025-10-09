<?php
namespace App\Controllers;

use App\Models\UserModel;
use Core\ApiResponse;

final class UserController
{
    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    /**
     * GET /api/users
     * Récupérer tous les utilisateurs
     */
    public function index(array $filters = []): void
    {
        $users = $this->model->getUsers($filters);
        ApiResponse::success('Liste des utilisateurs récupérée', $users);
    }

    /**
     * GET /api/users/{id}
     * Récupérer un utilisateur spécifique
     */
    public function show(int $id): void
    {
        $user = $this->model->getUser($id);
        ApiResponse::success("Utilisateur trouvé", $user);
    }

    /**
     * POST /api/users
     * Créer un nouvel utilisateur
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
     * Mettre à jour un utilisateur existant
     */
    public function update(int $id, array $data): void
    {
        $updated = $this->model->updateUser($id, $data);

        if ($updated) {
            ApiResponse::success("Utilisateur mis à jour avec succès");
        } else {
            ApiResponse::error("Erreur lors de la mise à jour de l'utilisateur", [], 500);
        }
    }

    /**
     * DELETE /api/users/{id}
     * Supprimer un utilisateur
     */
    public function delete(int $id): void
    {
        $deleted = $this->model->deleteUser($id);

        if ($deleted) {
            ApiResponse::success("Utilisateur supprimé avec succès");
        } else {
            ApiResponse::error("Erreur lors de la suppression de l'utilisateur", [], 500);
        }
    }
}
