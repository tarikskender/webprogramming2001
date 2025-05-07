<?php
require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/../BaseDao.php';

class UserDao extends BaseDao {

    public function __construct($conn) {
        parent::__construct($conn);
    }

    public function getUser($id) {
        $stmt = $this->executeQuery("SELECT * FROM users WHERE id = :id", ["id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        return $this->select("users");
    }

    public function createUser($data) {
        $this->insert("users", $data);
    }

    public function updateUser($id, $data) {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $set = implode(", ", $fields);
        $data['id'] = $id;

        $query = "UPDATE users SET $set WHERE id = :id";
        $this->executeQuery($query, $data);
    }

    public function deleteUser($id) {
        $this->executeQuery("DELETE FROM users WHERE id = :id", ["id" => $id]);
    }
}
?>
