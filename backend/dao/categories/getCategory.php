<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
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

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'id' parameter"]);
    exit;
}

$category = $dao->getCategory($_GET['id']);

if ($category) {
    echo json_encode($category);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Category not found"]);
}
?>
