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

echo json_encode($dao->getAllCategories());
?>
