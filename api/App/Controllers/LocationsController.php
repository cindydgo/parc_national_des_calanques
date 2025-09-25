<?php
namespace App\Controllers;

use App\Models\LocationsModel;
use Core\ApiResponse;
use Core\Helper;


final class LocationsController {
    private LocationsModel $locationModel;
    
    public function __construct() {
        $this->locationModel = new LocationsModel();
    }
    
    public function index(array $filters): void {
        $results = $this->locationModel->getAllLocations($filters);
        if ($results) {
            ApiResponse::success('Données récupérées', $results);
        }
        ApiResponse::error("No locations found.");
    }
    
    public function show(int $id): void {
        $results = $this->locationModel->getLocation($id);
        if ($results) {
            ApiResponse::success('Données récupérées', $results);
        }
        ApiResponse::error("No locations found.");
    }
    
    public function store(array $data): void {
        if ($this->locationModel->insertLocation($data)) {
            ApiResponse::success('Données récupérées');
        }
        ApiResponse::error("No locations found.");
    }
    
    public function edit(int $id, array $data): void {
        if ($this->locationModel->updateLocation($id, $data)) {
            ApiResponse::success('Données récupérées');
        }
        ApiResponse::error("No locations found.");
    }
    
    public function destroy(int $id): void {
        if ($this->locationModel->deleteLocation($id)) {
            ApiResponse::success('Données récupérées');
        }
        ApiResponse::error("No locations found.");
    }
}