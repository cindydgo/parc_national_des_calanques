<?php
namespace App\Models;

use Core\Model;
use Core\ApiResponse;

final class CampingModel extends Model
{
    public function __construct()
    {
        parent::__construct('campings');
    }

    /**
     * Récupérer tous les campings
     */
    public function getCampings(array $filters = []): array
    {
        unset($filters['resource']);
        $campings = $this->all($filters);

        if (empty($campings)) {
            ApiResponse::success("Aucun camping trouvé", []);
        }

        return $campings;
    }

    /**
     * Récupérer un camping par son ID
     */
    public function getCamping(int $id): ?array
    {
        $camping = $this->find($id);

        if (!$camping) {
            ApiResponse::error("Aucun camping trouvé avec l'ID $id", [], 404);
        }

        return $camping;
    }

    /**
     * Créer un nouveau camping
     */
    public function createCamping(array $data): bool
    {
        if (empty($data['name']) || empty($data['location'])) {
            ApiResponse::error("Les champs 'nom' et 'location' sont requis");
        }

        return $this->create($data);
    }

    /**
     * Mettre à jour un camping existant
     */
    public function updateCamping(int $id, array $data): bool
    {
        $camping = $this->find($id);
        if (!$camping) {
            ApiResponse::error("Camping introuvable pour mise à jour", [], 404);
        }

        return $this->update($id, $data);
    }

    /**
     * Supprimer un camping
     */
    public function deleteCamping(int $id): bool
    {
        $camping = $this->find($id);
        if (!$camping) {
            ApiResponse::error("Camping introuvable pour suppression", [], 404);
        }

        return $this->delete($id);
    }
}
