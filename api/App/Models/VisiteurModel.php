<?php
namespace App\Models;

use Core\Model;


final class VisiteurModel extends Model
{
    public function __construct()
    {
        parent::__construct('visiteurs');
    }

    /**
     * Create a new visitor
     * @param array $data Visitor data
     * @return bool
     */
    public function createVisiteur(array $data): bool
    {
        return $this->create($data);
    }

    /**
     * Get a single visitor by ID
     * @param int $id Visitor ID
     * @return array|null
     */
    public function getVisiteur(int $id): ?array
    {
        $visiteur = $this->find($id);

        return $visiteur;
    }

    /**
     * Get all visitors with optional filters
     * @param array $data Visitors data
     * @return array
     */
    public function getVisiteurs(array $filters = []): array
    {
        $visiteurs = $this->all($filters);

        return $visiteurs;
    }

    /**
     * Update an existing visitor
     * @param int $id Visitor ID
     * @param array $data Visitor data
     * @return bool
     */
    public function updateVisiteur(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    /**
     * Delete a visitor by ID
     * @param int $id Visitor ID
     * @return bool
     */
    public function deleteVisiteur(int $id): bool
    {
        return $this->delete($id);
    }
}
