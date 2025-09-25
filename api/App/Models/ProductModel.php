<?php
namespace App\Models;

final class ProductModel extends Model {
    public static function init(): void {
        parent::setTableName('product_models');
    }
    
    // Récupérer les détails d'un produit spécifique
    public static function details(int $id): array {
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
        
        return parent::sqlQuery($query, ['id' => $id])
            ? parent::$cursor->fetch()
            : [];
    }
    
    // Récupérer une liste de produits à partir de filtres spécifiques
    public static function findByFilters(array $filters = [], int $limit = 20, int $offset = 0): array {
        $query = 'SELECT * FROM product_component_items WHERE 1 = 1';
        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $query .= " AND pci.$key = :$key";
            }
        }
        $query .= " LIMIT $limit, $offset;";
        
        parent::sqlQuery($query, $filters);
        return parent::$cursor->fetchAll();
    }
    
    // Récupérer une liste de produits depuis une recherche
    public static function findByResearch(string $search): array {
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
        
        parent::sqlQuery($query, ['s' => $search]);
        return parent::$cursor->fetchAll();
    }
}