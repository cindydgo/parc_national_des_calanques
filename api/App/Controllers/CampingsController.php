<?php
namespace App\Controllers;

use App\Models\CampingModel;
use Core\ApiResponse;
use Utils\Auth;

final class CampingsController
{
    private CampingModel $model;

    public function __construct()
    {
        $this->model = new CampingModel();
    }

    /**
     * GET /api/campings
     * Get all campings with optional filters
     * @param array $filters Filters to apply
     * @return void
     */
    public function index(array $filters = []): void
    {
        unset($filters['resource']);
        $campings = $this->model->getCampings($filters);
        ApiResponse::success('Liste des campings récupérée', $campings);
    }

    /**
     * GET /api/campings/{id}
     * Get a single camping by ID
     * @param int $id Camping ID
     * @return void
     */
    public function show(int $id): void
    {
        $camping = $this->model->getCamping($id);
        ApiResponse::success("Camping trouvé", $camping);
    }

    /**
     * POST /api/campings
     * Create a new camping
     * @param array $data Camping data
     * @return void
     */
    public function store(array $data): void
    {
        $created = $this->model->createCamping($data);

        if ($created) {
            ApiResponse::success("Camping créé avec succès", $data, 201);
        } else {
            ApiResponse::error("Erreur lors de la création du camping", [], 500);
        }
    }

    /**
     * PUT /api/campings/{id}
     * Update an existing camping
     * @param int $id Camping ID
     * @param array $data Camping data
     * @return void
     */
    public function update(int $id, array $data): void
    {
        $updated = $this->model->updateCamping($id, $data);

        if ($updated) {
            ApiResponse::success("Camping mis à jour avec succès,", $data, 200);
        } else {
            ApiResponse::error("Erreur lors de la mise à jour du camping", [], 500);
        }
    }

    /**
     * DELETE /api/campings/{id}
     * Delete a camping by ID
     * @param int $id Camping ID    
     * @return void
     */
    public function delete(int $id): void
    {
        $deleted = $this->model->deleteCamping($id);

        if ($deleted) {
            ApiResponse::success("Camping supprimé avec succès", [], 200);
        } else {
            ApiResponse::error("Erreur lors de la suppression du camping", [], 500);
        }
    }
}
