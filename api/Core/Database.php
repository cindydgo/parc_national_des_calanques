<?php
namespace Core;

use PDO;
use PDOStatement;
use Exception;

abstract class Database {
    private ?PDO $pdo = null;
    protected ?PDOStatement $stmt = null;
    protected string $tableName;
    
    public function __construct(string $tableName) {
        $this->tableName = $tableName;
        $this->connect();
    }
    
    protected function connect(): void {
        try {
            $this->pdo = new PDO(
                'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8',
                $_ENV['DB_USER'], $_ENV['DB_PASS']
            );
        } catch (Exception $err) {
            throw new Exception("Une erreur est survenue lors de la connexion à la base de donnée.\nErreur: {$err->getMessage()}");
        }
    }
    
    protected function sqlQuery(string $query, array $params): bool {
        $this->getConnection();
        
        try {
            $this->stmt = $this->pdo->prepare($query);
            return $this->stmt->execute($params);
        } catch (Exception $err) {
            throw new Exception("Une erreur est survenue lors de l'exécution de la requête suivante :\n- $query\nErreur : {$err->getMessage()}");
        }
    }
    
    // Create
    protected function create(array $data): bool {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($k) => ":$k", array_keys($data)));
        return $this->sqlQuery("INSERT INTO $this->tableName ($fields) VALUES ($placeholders)", $data);
    }
    
    // Read
    protected function readOne(int $id): ?array {
        $this->sqlQuery("SELECT * FROM $this->tableName WHERE id = :id;", ['id' => $id]);
        $result= $this->stmt->fetch(PDO::FETCH_ASSOC);
        return $result === false ? null : $result;
    }
    
    protected function readAll(array $filters): array {
        $this->sqlQuery("SELECT * FROM $this->tableName " . $this->buildClauses($filters) . ';', $filters);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Update
    protected function update(int $id, array $data): bool {
        $setters = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        return $this->sqlQuery("UPDATE $this->tableName SET $setters WHERE id = :id;", ['id' => $id, ...$data]);
    }
    
    // Delete
    protected function delete(int $id): bool {
        return $this->sqlQuery("DELETE FROM $this->tableName WHERE id = :id;", ['id' => $id]);
    }
    
    private function getConnection(): void {
        if (!$this->pdo) {
            $this->connect();
        }
    }
    
    /**
     * Construit dynamiquement les clauses SQL à partir des filtres fournis.
     * Cette méthode supporte uniquement :
     * Des conditions de type AND dans la clause WHERE
     * Un GROUP BY simple
     * Un ORDER BY simple avec direction
     * Un LIMIT/OFFSET
     *
     * Ne gère pas :
     * Les jointures (JOIN)
     * Les alias de colonnes ou de tables
     * Les conditions complexes (OR, IN, BETWEEN, etc.)
     *
     * @param array $filters
     * @return string
     */
    protected function buildClauses(array &$filters): string {
        $otherClauses = $this->getOtherClauses($filters);
        $whereClauses = $this->getWhereClauses($filters);
        
        $formattedClauses = '';
        if (!empty($whereClauses)) {
            $formattedClauses .= ' WHERE ' . $whereClauses;
        }
        
        $formattedClauses .= $otherClauses;
        return $formattedClauses;
    }
    
    /**
     * Retourne une chaîne correspondante à toutes les clauses qui ne sont pas de type WHERE
     * @param array $filters
     * @return string
     */
    private function getOtherClauses(array &$filters): string {
        $clauses = '';
        
        if (isset($filters['group_by'])) {
            $clauses .= " GROUP BY {$filters['group_by']}";
        }
        
        if (isset($filters['order_by'])) {
            $direction = isset($filters['order_dir']) && strtolower($filters['order_dir']) === 'asc' ? 'ASC' : 'DESC';
            $clauses .= " ORDER BY {$filters['order_by']} $direction";
        }
        
        if (isset($filters['limit'])) {
            $limit = is_numeric($filters['limit'])                                  ? (int) $filters['limit']   : 20;
            $offset = isset($filters['offset']) && is_numeric($filters['offset'])   ? (int) $filters['offset']  : 0;
            $clauses .= " LIMIT $limit OFFSET $offset";
        }
        
        unset($filters['group_by'], $filters['order_by'], $filters['order_dir'], $filters['limit'], $filters['offset']);
        return $clauses;
    }
    
    /**
     * Retourne une chaîne correspondante à toutes les clauses de type WHERE
     * @param array $filters
     * @return string
     */
    private function getWhereClauses(array $filters): string {
        $clauses = [];
        foreach (array_keys($filters) as $key) {
            $clauses[] = "$key = :$key";
        }
        return implode(' AND ', $clauses);
    }
}