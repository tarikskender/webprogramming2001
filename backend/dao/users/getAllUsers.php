<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/UserDao.php';

$database = new Database();
$conn = $database->getConnection();

$dao = new UserDao($conn);
$users = $dao->getAllUsers();

echo json_encode($users);
?>
