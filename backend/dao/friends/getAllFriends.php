<?php
require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/FriendDao.php';

$database = new Database();
$conn = $database->getConnection();
$dao = new FriendDao($conn);

echo json_encode($dao->getAllFriends());
?>
