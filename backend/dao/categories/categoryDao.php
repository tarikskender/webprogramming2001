<?php
require_once __DIR__ . '/../BaseDao.php';

class CategoryDao extends BaseDao {
    public function __construct($conn) {
        parent::__construct($conn);
    }

    public function getAllCategories() {
        return $this->select("categories");
    }

    public function getCategory($id) {
        $stmt = $this->executeQuery("SELECT * FROM categories WHERE id = :id", ["id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCategory($data) {
        return $this->insert("categories", $data);
    }

    public function updateCategory($id, $data) {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $sql = "UPDATE categories SET " . implode(", ", $fields) . " WHERE id = :id";
        $data['id'] = $id;
        $this->executeQuery($sql, $data);
    }

    public function deleteCategory($id) {
        $this->executeQuery("DELETE FROM categories WHERE id = :id", ["id" => $id]);
    }
}
?>
