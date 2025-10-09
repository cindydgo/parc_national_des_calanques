<?php
namespace App\Models;

use Core\Model;
use Core\ApiResponse;

final class SentierModel extends Model
{
    public function __construct()
    {
        parent::__construct('sentiers');
    }

    /**
     * Récupérer tous les sentiers
     */
    public function getSentiers(array $filters = []): array
    {
        unset($filters['resource']);
        $sentiers = $this->all($filters);

        if (empty($sentiers)) {
            ApiResponse::success("Aucun sentier trouvé", []);
        }

        return $sentiers;
    }

    /**
     * Récupérer un sentier par son ID
     */
    public function getSentier(int $id): ?array
    {
        $sentier = $this->find($id);

        if (!$sentier) {
            ApiResponse::error("Aucun sentier trouvé avec l'ID $id", [], 404);
        }

        return $sentier;
    }

    /**
     * Créer un nouveau sentier
     */
    public function createSentier(array $data): bool
    {
        if (empty($data['name']) || empty($data['difficulty'])) {
            ApiResponse::error("Les champs 'nom' et 'difficulté' sont requis");
        }

        return $this->create($data);
    }

    /**
     * Mettre à jour un sentier existant
     */
    public function updateSentier(int $id, array $data): bool
    {
        $sentier = $this->find($id);
        if (!$sentier) {
            ApiResponse::error("Sentier introuvable pour mise à jour", [], 404);
        }

        return $this->update($id, $data);
    }

    /**
     * Supprimer un sentier
     */
    public function deleteSentier(int $id): bool
    {
        $sentier = $this->find($id);
        if (!$sentier) {
            ApiResponse::error("Sentier introuvable pour suppression", [], 404);
        }

        return $this->delete($id);
    }
}
