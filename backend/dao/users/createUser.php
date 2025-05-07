<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// ✅ Handle preflight request
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

// Validate required fields
if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'name', 'email', or 'password'"]);
    exit;
}

$dao = new UserDao($conn);
$dao->createUser($data);

echo json_encode(["message" => "User created"]);
?>
