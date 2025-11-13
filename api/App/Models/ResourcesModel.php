<?php
namespace App\Models;

use Core\Model;
use Core\ApiResponse;

final class ResourcesModel extends Model
{
    public function __construct()
    {
        parent::__construct('ressources');
    }

    /**
     * Get all resources with optional filters
     * @param array $filters Filters to apply
     * @return array
     */
    public function getResources(array $filters = []): array
    {
        $resources = $this->all($filters);

        return $resources;
    }

    /**
     * Get a single resource by ID
     * @param int $id Resource ID
     * @return array|null
     */
    public function getResource(int $id): ?array
    {
        $resource = $this->find($id);

        return $resource;
    }

    /**
     * Create a new resource
     * @param array $data Resource data
     * @return bool
     */
    public function createResource(array $data): bool
    {
        return $this->create($data);
    }

    /**
     * Update an existing resource
     * @param int $id Resource ID
     * @param array $data Resource data
     * @return bool
     */
    public function updateResource(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    /**
     * Delete a resource
     * @param int $id Resource ID
     * @return bool
     */
    public function deleteResource(int $id): bool
    {
        return $this->delete($id);
    }
}
