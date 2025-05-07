<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/CategoryDao.php';

$database = new Database();
$conn = $database->getConnection();
$dao = new CategoryDao($conn);

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'id'"]);
    exit;
}

$dao->deleteCategory($data['id']);
echo json_encode(["message" => "Category deleted"]);
?>
