<?php
namespace App\Models;

use Core\Database;

final class LocationsModel extends Database {
    public function __construct() {
        parent::__construct('locations');
    }
    
    // Create
    public function insertLocation(array $data): bool {
        return $this->create($data);
    }
    
    // Read
    public function getLocation(int $id): array {
        return $this->readOne($id);
    }
    
    public function getAllLocations(array $filters): array {
        return $this->readAll($filters);
    }
    
    // Update
    public function updateLocation(int $id, array $data): bool {
        return $this->update($id, $data);
    }
    
    // Delete
    public function deleteLocation(int $id): bool {
        return $this->delete($id);
    }
}

