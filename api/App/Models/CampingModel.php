<?php
namespace App\Models;

use Core\Model;

final class CampingModel extends Model
{
    public function __construct()
    {
        parent::__construct('campings');
    }

    /**
     * Get all campings with optional filters
     * @param array $filters Filters to apply
     * @return array
     */
    public function getCampings(array $filters = []): array
    {
        $campings = $this->all($filters);

        return $campings;
    }

    /**
     * Get a single camping by ID
     * @param int $id Camping ID
     * @return array|null   
     */
    public function getCamping(int $id): ?array
    {
        $camping = $this->find($id);

        return $camping;
    }

    /**
     * Create a new camping
     * @param array $data User data
     * @return bool
     */
    public function createCamping(array $data): bool
    {
        return $this->create($data);
    }

    /**
     * Update an existing camping
     * @param int $id Camping ID
     * @param array $data Camping data
     * @return bool
     */
    public function updateCamping(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    /**
     * Delete a camping
     * @param int $id Camping ID
     * @return bool
     */
    public function deleteCamping(int $id): bool
    {
        return $this->delete($id);
    }
}
