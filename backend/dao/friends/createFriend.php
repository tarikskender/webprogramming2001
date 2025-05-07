<?php
// 🔧 CORS fix
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

// ✅ Logic
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

$dao->createFriendship($data['user_id'], $data['friend_id']);
echo json_encode(["message" => "Friendship created"]);
?>