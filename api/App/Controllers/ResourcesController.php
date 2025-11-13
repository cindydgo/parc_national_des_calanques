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
     * Get all resources with optional filters
     * @param array $filters Filters to apply
     * @return void
     */
    public function index(array $filters = []): void
    {
        unset($filters['resource']);
        $resources = $this->model->getResources($filters);
        ApiResponse::success('Liste des ressources naturelles récupérée', $resources, 200);
    }

    /**
     * GET /api/resources/{id}
     * Get a single resource by ID
     * @param int $id Resource ID
     * @return void
     */
    public function show(int $id): void
    {
        $resource = $this->model->getResource($id);
        ApiResponse::success('Ressource naturelle trouvée', $resource, 200);
    }

    /**
     * POST /api/resources
     * Create a new resource
     * @param array $data Resource data
     * @return void
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
     * Update an existing resource
     * @param int $id Resource ID
     * @param array $data Resource data
     * @return void
     */
    public function update(int $id, array $data): void
    {
        $updated = $this->model->updateResource($id, $data);

        if ($updated) {
            ApiResponse::success("Ressource mise à jour avec succès", $data, 200);
        } else {
            ApiResponse::error("Erreur lors de la mise à jour de la ressource", [], 500);
        }
    }

    /**
     * DELETE /api/resources/{id}
     * Delete a resource by ID
     * @param int $id Resource ID
     * @return void
     */
    public function delete(int $id): void
    {
        $deleted = $this->model->deleteResource($id);

        if ($deleted) {
            ApiResponse::success("Ressource supprimée avec succès", [], 200);
        } else {
            ApiResponse::error("Erreur lors de la suppression de la ressource", [], 500);
        }
    }
}
