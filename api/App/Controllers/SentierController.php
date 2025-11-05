<?php
namespace App\Controllers;

use App\Models\SentierModel;
use Core\ApiResponse;

final class SentierController
{
    private SentierModel $model;

    public function __construct()
    {
        $this->model = new SentierModel();
    }

    /**
     * GET /api/sentiers
     */
    public function index(array $filters = []): void
    {
        $sentiers = $this->model->getSentiers($filters);
        ApiResponse::success('Liste des sentiers récupérée', $sentiers);
    }

    /**
     * GET /api/sentier/{id}
     */
    public function show(int $id): void
    {
        $sentier = $this->model->getSentier($id);
        ApiResponse::success('Sentier trouvé', $sentier);
    }

    /**
     * POST /api/Sentiers
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
     */
    public function update(int $id, array $data): void
    {
        $sentier = $this->model->updateSentier($id, $data);

        if ($sentier) {
            ApiResponse::success("Sentier mis à jour avec succès");
        } else {
            ApiResponse::error("Erreur lors de la mise à jour du sentier", [], 500);
        }
    }

    /**
     * DELETE /api/sentiers/{id}
     */
    public function delete(int $id): void
    {
        $sentier = $this->model->deleteSentier($id);

        if ($sentier) {
            ApiResponse::success("Sentier supprimé avec succès");
        } else {
            ApiResponse::error("Erreur lors de la suppression du sentier", [], 500);
        }
    }
}
