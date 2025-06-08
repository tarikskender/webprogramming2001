<?php
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/BaseDao.php';

class TaskDao extends BaseDao {
    public function __construct() {
        $db   = new Database();
        $conn = $db->getConnection();
        parent::__construct($conn, 'tasks');
    }
    // all CRUD ops are inherited from BaseDao
}
