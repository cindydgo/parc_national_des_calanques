<?php
namespace App\Models;

use App\Core\Model;

final class ProductModel extends Model
{
    public function __construct()
    {
        parent::__construct('product_component_items'); // nom de la table
    }

    /**
     * Récupérer les détails d'un produit spécifique
     */
    public function details(int $id): array
    {
        $query = '
            SELECT pci.*,
                   b.name AS brand_name,
                   g.name AS generation_name,
                   pr.name AS product_range_name,
                   cm.name AS custom_model_name,
                   pc.name AS component_name
            FROM product_component_items pci
            LEFT JOIN brands b ON b.id = pci.brand_fk
            LEFT JOIN generations g ON g.id = pci.generation_fk
            LEFT JOIN product_ranges pr ON pr.id = pci.product_range_fk
            LEFT JOIN custom_models cm ON cm.id = pci.custom_model_fk
            LEFT JOIN product_components pc ON pc.id = pci.product_component_fk
            WHERE pci.id = :id
            LIMIT 1;
        ';

        $this->sqlQuery($query, ['id' => $id]);
        return $this->stmt ? $this->stmt->fetch(\PDO::FETCH_ASSOC) : [];
    }

    /**
     * Récupérer une liste de produits à partir de filtres spécifiques
     */
    public function findByFilters(array $filters = [], int $limit = 20, int $offset = 0): array
    {
        $query = 'SELECT * FROM product_component_items pci WHERE 1 = 1';

        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $query .= " AND pci.$key = :$key";
            }
        }

        $query .= " LIMIT :limit OFFSET :offset";
        $filters['limit'] = $limit;
        $filters['offset'] = $offset;

        $this->sqlQuery($query, $filters);
        return $this->stmt ? $this->stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
    }

    /**
     * Récupérer une liste de produits depuis une recherche textuelle
     */
    public function findByResearch(string $search): array
    {
        $query = '
            SELECT pci.*,
                   b.name AS brand_name,
                   g.name AS generation_name,
                   pr.name AS product_range_name,
                   cm.name AS custom_model_name,
                   pc.name AS component_name
            FROM product_component_items pci
            LEFT JOIN brands b ON b.id = pci.brand_fk
            LEFT JOIN generations g ON g.id = pci.generation_fk
            LEFT JOIN product_ranges pr ON pr.id = pci.product_range_fk
            LEFT JOIN custom_models cm ON cm.id = pci.custom_model_fk
            LEFT JOIN product_components pc ON pc.id = pci.product_component_fk
            WHERE pc.name LIKE :s OR b.name LIKE :s OR cm.name LIKE :s
        ';

        $this->sqlQuery($query, ['s' => "%$search%"]);
        return $this->stmt ? $this->stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
    }
}
