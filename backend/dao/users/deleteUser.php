<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/UserDao.php';

$database = new Database();
$conn = $database->getConnection();

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'id'"]);
    exit;
}

$dao = new UserDao($conn);
$dao->deleteUser($data['id']);

echo json_encode(["message" => "User deleted"]);
?>
