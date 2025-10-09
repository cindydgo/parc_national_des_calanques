<?php
namespace App\Models;

use Core\Model;
use Core\ApiResponse;

final class ResourcesModel extends Model
{
    public function __construct()
    {
        parent::__construct('ressources');
    }

    /**
     * Récupérer toutes les ressources naturelles
     */
    public function getResources(array $filters = []): array
    {
        unset($filters['resource']);
        $resources = $this->all($filters);

        if (empty($resources)) {
            ApiResponse::success("Aucune ressource naturelle trouvée", []);
        }

        return $resources;
    }

    /**
     * Récupérer une ressource par son ID
     */
    public function getResource(int $id): ?array
    {
        $resource = $this->find($id);

        if (!$resource) {
            ApiResponse::error("Aucune ressource trouvée avec l'ID $id", [], 404);
        }

        return $resource;
    }

    /**
     * Créer une nouvelle ressource
     */
    public function createResource(array $data): bool
    {
        if (empty($data['name']) || empty($data['type'])) {
            ApiResponse::error("Les champs 'name' et 'type' sont requis");
        }

        return $this->create($data);
    }

    /**
     * Mettre à jour une ressource existante
     */
    public function updateResource(int $id, array $data): bool
    {
        $resource = $this->find($id);
        if (!$resource) {
            ApiResponse::error("Ressource introuvable pour mise à jour", [], 404);
        }

        return $this->update($id, $data);
    }

    /**
     * Supprimer une ressource
     */
    public function deleteResource(int $id): bool
    {
        $resource = $this->find($id);
        if (!$resource) {
            ApiResponse::error("Ressource introuvable pour suppression", [], 404);
        }

        return $this->delete($id);
    }
}
