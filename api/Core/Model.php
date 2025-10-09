<?php
namespace Core;

use Core\Database;

abstract class Model extends Database {
    protected string $table; // nom de la table associée au modèle

    /**
     * Constructeur
     */
    public function __construct(string $table = '')
    {
        // Si la classe fille définit $table, on l'utilise, sinon on prend le paramètre
        $tableName = $table ?: $this->table;
        parent::__construct($tableName);
    }

    /**
     * Récupérer un enregistrement par ID
     */
    public function find(int $id): ?array
    {
        return $this->readOne($id);
    }

    /**
     * Récupérer tous les enregistrements avec filtres optionnels
     */
    public function all(array $filters = []): array
    {
        return $this->readAll($filters);
    }

    /**
     * Créer un nouvel enregistrement
     */
    public function create(array $data): bool
    {
        return parent::create($data);
    }

    public function update(int $id, array $data): bool {
    return parent::update($id, $data);
    }

    public function delete(int $id): bool {
        return parent::delete($id);
    }

}