<?php
namespace App\Models;

use Core\Model;
use Core\ApiResponse;

final class UserModel extends Model
{
    public function __construct()
    {
        parent::__construct('users');
    }

    /**
     * Récupérer tous les utilisateurs
     */
    public function getUsers(array $filters = []): array
    {
        unset($filters['resource']);
        $users = $this->all($filters);

        if (empty($users)) {
            ApiResponse::success("Aucun utilisateur trouvé", []);
        }

        return $users;
    }

    /**
     * Récupérer un utilisateur par son ID
     */
    public function getUser(int $id): ?array
    {
        $user = $this->find($id);

        if (!$user) {
            ApiResponse::error("Aucun visiteur trouvé avec l'ID $id", [], 404);
        }

        return $user;
    }

    /**
     * Créer un nouvel utilisateur
     */
    public function createUser(array $data): bool
    {
        if (empty($data['nom']) || empty($data['email'])) {
            ApiResponse::error("Les champs 'nom' et 'email' sont requis");
        }

        return $this->create($data);
    }

    /**
     * Mettre à jour un utilisateur existant
     */
    public function updateUser(int $id, array $data): bool
    {
        $user = $this->find($id);
        if (!$user) {
            ApiResponse::error("Utilisateur introuvable pour mise à jour", [], 404);
        }

        return $this->update($id, $data);
    }

    /**
     * Supprimer un utilisateur
     */
    public function deleteUser(int $id): bool
    {
        $user = $this->find($id);
        if (!$user) {
            ApiResponse::error("Utilisateur introuvable pour suppression", [], 404);
        }

        return $this->delete($id);
    }
}
