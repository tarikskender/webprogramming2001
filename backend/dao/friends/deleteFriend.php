<?php
require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/FriendDao.php';

$database = new Database();
$conn = $database->getConnection();
$dao = new FriendDao($conn);

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id'], $data['friend_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'user_id' or 'friend_id'"]);
    exit;
}

$dao->deleteFriendship($data['user_id'], $data['friend_id']);
echo json_encode(["message" => "Friendship deleted"]);
?>
