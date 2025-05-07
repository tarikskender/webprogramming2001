<?php
require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/FriendDao.php';

$database = new Database();
$conn = $database->getConnection();
$dao = new FriendDao($conn);

$user_id = $_GET['user_id'] ?? null;
$friend_id = $_GET['friend_id'] ?? null;

if (!$user_id || !$friend_id) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'user_id' or 'friend_id'"]);
    exit;
}

echo json_encode($dao->getFriendship($user_id, $friend_id));
?>
