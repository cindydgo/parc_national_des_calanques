<?php
namespace App\Models;

use Core\Model;

final class CampingAmenityModel extends Model
{
    public function __construct()
    {
        parent::__construct('camping_amenities');
    }

    /**
     * Get all camping amenities with optional filters
     * @param array $filters Filters to apply
     * @return array
     */
    public function getCampingAmenities(array $filters = []): array
    {
        $campingAmenities = $this->all($filters);

        return $campingAmenities;
    }
}
