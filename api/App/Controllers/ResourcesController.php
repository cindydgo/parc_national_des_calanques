<?php
namespace App\Controllers;

use App\Models\ResourcesModel;
use Core\ApiResponse;

final class ResourcesController
{
    private ResourcesModel $model;

    public function __construct()
    {
        $this->model = new ResourcesModel();
    }

    /**
     * GET /api/resources
     */
    public function index(array $filters = []): void
    {
        $resources = $this->model->getResources($filters);
        ApiResponse::success('Liste des ressources naturelles récupérée', $resources);
    }

    /**
     * GET /api/resources/{id}
     */
    public function show(int $id): void
    {
        $resource = $this->model->getResource($id);
        ApiResponse::success('Ressource naturelle trouvée', $resource);
    }

    /**
     * POST /api/resources
     */
    public function store(array $data): void
    {
        $created = $this->model->createResource($data);

        if ($created) {
            ApiResponse::success('Ressource créée avec succès', $data, 201);
        } else {
            ApiResponse::error("Erreur lors de la création de la ressource", [], 500);
        }
    }

    /**
     * PUT /api/resources/{id}
     */
    public function update(int $id, array $data): void
    {
        $updated = $this->model->updateResource($id, $data);

        if ($updated) {
            ApiResponse::success("Ressource mise à jour avec succès");
        } else {
            ApiResponse::error("Erreur lors de la mise à jour de la ressource", [], 500);
        }
    }

    /**
     * DELETE /api/resources/{id}
     */
    public function delete(int $id): void
    {
        $deleted = $this->model->deleteResource($id);

        if ($deleted) {
            ApiResponse::success("Ressource supprimée avec succès");
        } else {
            ApiResponse::error("Erreur lors de la suppression de la ressource", [], 500);
        }
    }
}
