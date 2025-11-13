<?php
namespace App\Models;

use Core\Model;
use Core\ApiResponse;

final class SentierModel extends Model
{
    public function __construct()
    {
        parent::__construct('sentiers');
    }

    /**
     * Get all trails with optional filters
     * @param array $filters Filters to apply
     * @return array
     */
    public function getSentiers(array $filters = []): array
    {
        $sentiers = $this->all($filters);

        return $sentiers;
    }

    /**
     * Get a single trail by ID
     * @param int $id trail ID
     * @return array|null
     */
    public function getSentier(int $id): ?array
    {
        $sentier = $this->find($id);

        return $sentier;
    }

    /**
     * Create a new trail
     * @param array $data trail data
     * @return bool
     */
    public function createSentier(array $data): bool
    {
        return $this->create($data);
    }

    /**
     * Update an existing trail
     * @param int $id trail ID
     * @param array $data trail data
     * @return bool
     */
    public function updateSentier(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    /**
     * Delete a trail
     * @param int $id trail ID
     * @return bool
     */
    public function deleteSentier(int $id): bool
    {
        return $this->delete($id);
    }
}
