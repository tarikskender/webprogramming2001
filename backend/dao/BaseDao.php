<?php

class BaseDao {
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    protected function executeQuery($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function insert($table, $data) {
        $fields = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $this->executeQuery($query, $data);
        return $stmt;
    }
    
    public function select($table, $orderBy = null) {
        $query = "SELECT * FROM $table";
        if ($orderBy) {
            $query .= " ORDER BY " . $orderBy;
        }
        $stmt = $this->executeQuery($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
