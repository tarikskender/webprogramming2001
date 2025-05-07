<?php
require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/FollowDao.php';

$database = new Database();
$conn = $database->getConnection();
$dao = new FollowDao($conn);

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['follower_id'], $data['followed_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'follower_id' or 'followed_id'"]);
    exit;
}

$dao->deleteFollow($data['follower_id'], $data['followed_id']);
echo json_encode(["message" => "Follow deleted"]);
?>
