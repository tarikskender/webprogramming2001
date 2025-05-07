<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
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

$dao = new UserDao($conn);

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'id' parameter"]);
    exit;
}

$user = $dao->getUser($_GET['id']);

if ($user) {
    echo json_encode($user);
} else {
    http_response_code(404);
    echo json_encode(["error" => "User not found"]);
}
?>
