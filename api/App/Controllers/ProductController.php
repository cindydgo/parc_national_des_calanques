<?php
namespace App\Controllers;

use App\Models\ProductModel;

class ProductController {
    // Initializes the ProductModel model and retrieves all items
    public function index(array $filters = []): void {
        ProductModel::init();
        $results = ProductModel::findByFilters($filters);
        echo json_encode($results);
    }
    
    // Retrieves a product component item by its ID
    public function show(int $id): void {
        ProductModel::init();
        $details = ProductModel::details($id);
        echo json_encode($details);
    }
    
    // Creates a new product component item
    public function store(array $data): void {
        ProductModel::init();
        $id = ProductModel::create($data);
        echo json_encode(["success" => true, "id" => $id]);
    }
    
    // Updates a product component item by its ID
    public function update(array $data): void {
        ProductModel::init();
        $id = $data['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "ID manquant."]);
            return;
        }
        unset($data['id']);
        $ok = ProductModel::updateByID($id, $data);
        echo json_encode(["success" => $ok]);
    }
    
    // Deletes a product component item by its ID
    public function destroy(int $id): void {
        ProductModel::init();
        $ok = ProductModel::deleteByID($id);
        echo json_encode(["success" => $ok]);
    }
}