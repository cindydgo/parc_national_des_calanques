<?php
namespace App\Models;

use Core\Model;

final class AmenityModel extends Model
{
    public function __construct()
    {
        parent::__construct('amenities');
    }

    /**
     * Get all amenities with optional filters
     * @param array $filters Filters to apply
     * @return array
     */
    public function getAmenities(array $filters = []): array
    {
        $amenities = $this->all($filters);

        return $amenities;
    }
}
