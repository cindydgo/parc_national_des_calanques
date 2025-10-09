<?php
namespace App\Controllers;

use App\Models\CampingModel;
use Core\ApiResponse;

final class CampingController
{
    private CampingModel $model;

    public function __construct()
    {
        $this->model = new CampingModel();
    }

    /**
     * GET /api/campings
     * Récupérer tous les campings
     */
    public function index(array $filters = []): void
    {
        $campings = $this->model->getCampings($filters);
        ApiResponse::success('Liste des campings récupérée', $campings);
    }

    /**
     * GET /api/campings/{id}
     * Récupérer un camping spécifique
     */
    public function show(int $id): void
    {
        $camping = $this->model->getCamping($id);
        ApiResponse::success("Camping trouvé", $camping);
    }

    /**
     * POST /api/campings
     * Créer un nouveau camping
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
     * Mettre à jour un camping existant
     */
    public function update(int $id, array $data): void
    {
        $updated = $this->model->updateCamping($id, $data);

        if ($updated) {
            ApiResponse::success("Camping mis à jour avec succès");
        } else {
            ApiResponse::error("Erreur lors de la mise à jour du camping", [], 500);
        }
    }

    /**
     * DELETE /api/campings/{id}
     * Supprimer un camping
     */
    public function delete(int $id): void
    {
        $deleted = $this->model->deleteCamping($id);

        if ($deleted) {
            ApiResponse::success("Camping supprimé avec succès");
        } else {
            ApiResponse::error("Erreur lors de la suppression du camping", [], 500);
        }
    }
}
