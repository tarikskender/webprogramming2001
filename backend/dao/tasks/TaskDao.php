<?php
// TaskDao.php
require_once __DIR__ . '/../BaseDao.php';
require_once __DIR__ . '/../../Database.php';

class TaskDao extends BaseDao {
    protected $table = "tasks";

    public function __construct($conn) {
        parent::__construct($conn);
    }

    public function createTask($title, $description, $user_id = null, $category_id = null, $status = null, $imageType = null) {
        $data = [
            'title'       => $title,
            'description' => $description,
            'user_id'     => $user_id,
            'category_id' => $category_id,
            'status'      => $status,
            'image_type'  => $imageType
        ];
        return $this->insert($this->table, $data);
    }

    public function getTasks() {
        return $this->select($this->table, "created_at DESC");
    }

    public function getTaskById($id) {
        $stmt = $this->executeQuery("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTask($id, $title, $description) {
        return $this->executeQuery(
            "UPDATE {$this->table} SET title = :title, description = :description WHERE id = :id",
            ['title' => $title, 'description' => $description, 'id' => $id]
        );
    }

    public function deleteTask($id) {
        return $this->executeQuery("DELETE FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }
}
?>
