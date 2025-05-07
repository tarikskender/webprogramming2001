<?php
require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/FollowDao.php';

$database = new Database();
$conn = $database->getConnection();
$dao = new FollowDao($conn);

echo json_encode($dao->getAllFollows());
?>
