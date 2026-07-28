<?php
namespace App\Controllers;

use App\Models\AmenityModel;
use Core\ApiResponse;

final class AmenitiesController
{
    private AmenityModel $model;

    public function __construct()
    {
        $this->model = new AmenityModel();
    }

    /**
     * GET /api/amenities
     * Get all amenities with optional filters
     * @param array $filters Filters to apply
     * @return void
     */
    public function index(array $filters = []): void
    {
        unset($filters['resource']);
        $amenities = $this->model->getAmenities($filters);
        ApiResponse::success('Liste des équipements récupérée', $amenities);
    }
}
