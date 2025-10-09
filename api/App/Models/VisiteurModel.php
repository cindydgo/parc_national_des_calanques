<?php
namespace App\Models;

use Core\Model;
use Core\ApiResponse;

final class VisiteurModel extends Model
{
    /**
     * Constructeur - définit la table associée
     */
    public function __construct()
    {
        parent::__construct('visiteurs'); // table "visiteurs" dans ta BDD
    }

    /**
     * Crée un nouveau visiteur
     */
    public function createVisiteur(array $data): bool
    {
        if (empty($data['nom']) || empty($data['email'])) {
            ApiResponse::error("Les champs 'nom' et 'email' sont requis");
        }

        return $this->create($data);
    }

    /**
     * Récupère un visiteur spécifique par ID
     */
    public function getVisiteur(int $id): ?array
    {
        $visiteur = $this->find($id);

        if (!$visiteur) {
            ApiResponse::error("Aucun visiteur trouvé avec l'ID $id", [], 404);
        }

        return $visiteur;
    }

    /**
     * Récupère tous les visiteurs avec filtres optionnels
     */
    public function getVisiteurs(array $filters = []): array
    {
        unset($filters['resource']);
        $visiteurs = $this->all($filters);

        if (empty($visiteurs)) {
            ApiResponse::success("Aucun visiteur trouvé", []);
        }

        return $visiteurs;
    }

    /**
     * Met à jour un visiteur existant
     */
    public function updateVisiteur(int $id, array $data): bool
    {
        $visiteur = $this->find($id);
        if (!$visiteur) {
            ApiResponse::error("Visiteur introuvable pour mise à jour", [], 404);
        }

        return $this->update($id, $data);
    }

    /**
     * Supprime un visiteur
     */
    public function deleteVisiteur(int $id): bool
    {
        $visiteur = $this->find($id);
        if (!$visiteur) {
            ApiResponse::error("Visiteur introuvable pour suppression", [], 404);
        }

        return $this->delete($id);
    }
}
