<?php
require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/FollowDao.php';

$database = new Database();
$conn = $database->getConnection();
$dao = new FollowDao($conn);

$follower_id = $_GET['follower_id'] ?? null;
$followed_id = $_GET['followed_id'] ?? null;

if (!$follower_id || !$followed_id) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'follower_id' or 'followed_id'"]);
    exit;
}

echo json_encode($dao->getFollow($follower_id, $followed_id));
?>
