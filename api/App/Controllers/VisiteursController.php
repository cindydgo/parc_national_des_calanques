<?php
namespace App\Controllers;

use App\Models\VisiteurModel;
use Core\ApiResponse;

final class VisiteursController
{
    private VisiteurModel $model;

    public function __construct()
    {
        $this->model = new VisiteurModel();
    }

    /**
     * GET /api/visiteurs/
     * Get all visitors with optional filters
     * @param array $filters Filters to apply
     * @return void
     */
    public function index(array $filters = []): void
    {
        unset($filters['resource']);
        $visiteurs = $this->model->getVisiteurs($filters);
        ApiResponse::success('Liste des visiteurs récupérée', $visiteurs);
    }

    /**
     * GET /api/visiteurs/{id}
     * Get a single visitor by ID
     * @param int $id Visitor ID
     * @return void
     */
    public function show(int $id): void
    {
        $visiteur = $this->model->getVisiteur($id);

        if (!$visiteur) {
            ApiResponse::error("Visiteur non trouvé", [], 404);
        }

        ApiResponse::success('Visiteur trouvé', $visiteur);
    }

    /**
     * POST /api/visiteurs/{id}
     * Create a new visitor
     * @param array $data Visitor data
     * @return void
     */
    public function store(array $data): void
    {
        if (empty($data['first_name']) || empty($data['email'])) {
            ApiResponse::error("Champs requis manquants : nom et email");
        }

        $created = $this->model->createVisiteur($data);

        if ($created) {
            ApiResponse::success("Visiteur créé avec succès", $data, 201);
        } else {
            ApiResponse::error("Erreur lors de la création du visiteur", [], 500);
        }
    }

    /**
     * PUT /api/visiteurs/{id}
     * Update an existing visitor
     * @param int $id Visitor ID
     * @param array $data Visitor data
     * @return void
     */
    public function update(int $id, array $data): void
    {
        $updated = $this->model->updateVisiteur($id, $data);

        if (!$updated) {
            ApiResponse::error("Erreur lors de la mise à jour du visiteur", [], 500);
        }

        ApiResponse::success("Visiteur mis à jour avec succès");
    }

    /**
     * DELETE /api/visteurs/{id}
     * Delete a visitor by ID
     * @param int $id Visitor ID
     * @return void
     */
    public function delete(int $id): void
    {
        $deleted = $this->model->deleteVisiteur($id);

        if (!$deleted) {
            ApiResponse::error("Erreur lors de la suppression du visiteur", [], 500);
        }

        ApiResponse::success("Visiteur supprimé avec succès");
    }
}
