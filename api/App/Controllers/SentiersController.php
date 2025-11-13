<?php
namespace App\Controllers;

use App\Models\SentierModel;
use Core\ApiResponse;

final class SentiersController
{
    private SentierModel $model;

    public function __construct()
    {
        $this->model = new SentierModel();
    }

    /**
     * GET /api/sentiers
     * Get all trails with optional filters
     * @param array $data Filters to apply
     * @return void
     */
    public function index(array $filters = []): void
    {
        unset($filters['resource']);
        $sentiers = $this->model->getSentiers($filters);
        ApiResponse::success('Liste des sentiers récupérée', $sentiers, 200);
    }

    /**
     * GET /api/sentier/{id}
     * Get a single trail by ID
     * @param int $id trail ID
     * @return void
     */
    public function show(int $id): void
    {
        $sentier = $this->model->getSentier($id);
        ApiResponse::success('Sentier trouvé', $sentier, 200);
    }

    /**
     * POST /api/Sentiers
     * Create a new trail
     * @param array $data trail data
     * @return void
     */
    public function store(array $data): void
    {
        $sentier = $this->model->createSentier($data);

        if ($sentier) {
            ApiResponse::success('Sentier créé avec succès', $data, 201);
        } else {
            ApiResponse::error("Erreur lors de la création du sentier", [], 500);
        }
    }

    /**
     * PUT /api/sentiers/{id}
     * Update an existing trail
     * @param int $id trail ID
     * @param array $data trail data
     * @return void
     */
    public function update(int $id, array $data): void
    {
        $sentier = $this->model->updateSentier($id, $data);

        if ($sentier) {
            ApiResponse::success("Sentier mis à jour avec succès", $data, 200);
        } else {
            ApiResponse::error("Erreur lors de la mise à jour du sentier", [], 500);
        }
    }

    /**
     * DELETE /api/sentiers/{id}
     * Delete a trail by ID
     * @param int $id trail ID
     * @return void
     */
    public function delete(int $id): void
    {
        $sentier = $this->model->deleteSentier($id);

        if ($sentier) {
            ApiResponse::success("Sentier supprimé avec succès", [], 200);
        } else {
            ApiResponse::error("Erreur lors de la suppression du sentier", [], 500);
        }
    }
}
