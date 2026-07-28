<?php
namespace App\Controllers;

use App\Models\CampingAmenityModel;
use Core\ApiResponse;

final class CampingAmenitiesController
{
    private CampingAmenityModel $model;

    public function __construct()
    {
        $this->model = new CampingAmenityModel();
    }

    /**
     * GET /api/camping_amenities
     * Get all camping amenities with optional filters
     * @param array $filters Filters to apply
     * @return void
     */
    public function index(array $filters = []): void
    {
        unset($filters['resource']);
        $campingAmenities = $this->model->getCampingAmenities($filters);
        ApiResponse::success('Liste des équipements des campings récupérée', $campingAmenities);
    }
}
