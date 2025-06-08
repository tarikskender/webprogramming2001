<?php
// show errors during development
ini_set('display_errors', 1);
error_reporting(E_ALL);

// CORS & JSON headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit(0);
header("Content-Type: application/json");

// only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error"=>"Invalid method"]);
    exit;
}

// read JSON body
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(["error"=>"Invalid JSON"]);
    exit;
}

// 1) validate name
if (empty($data['name'])) {
    http_response_code(400);
    echo json_encode(["field"=>"name","msg"=>"Name is required"]);
    exit;
}
// 2) validate email
if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["field"=>"email","msg"=>"Valid email required"]);
    exit;
}
// 3) validate password
if (empty($data['password']) || strlen($data['password']) < 8) {
    http_response_code(400);
    echo json_encode(["field"=>"password","msg"=>"Password must be ≥8 chars"]);
    exit;
}
// 4) confirm password match
if (!isset($data['confirm']) || $data['password'] !== $data['confirm']) {
    http_response_code(400);
    echo json_encode(["field"=>"confirm","msg"=>"Passwords must match"]);
    exit;
}
// 5) terms checkbox
if (empty($data['terms']) || $data['terms'] !== true) {
    http_response_code(400);
    echo json_encode(["field"=>"terms","msg"=>"You must accept terms"]);
    exit;
}

// sanitize & hash
$name     = htmlspecialchars(trim($data['name']), ENT_QUOTES);
$email    = htmlspecialchars(trim($data['email']), ENT_QUOTES);
$password = password_hash($data['password'], PASSWORD_DEFAULT);

// include your Database class
require_once __DIR__ . '/../../Database.php';

try {
    // connect & insert
    $db  = new Database();
    $pdo = $db->getConnection();

    $stmt = $pdo->prepare("
      INSERT INTO users (name,email,password)
      VALUES (:name,:email,:password)
    ");
    $stmt->execute([
      ':name'     => $name,
      ':email'    => $email,
      ':password' => $password
    ]);

    http_response_code(201);
    echo json_encode(["success"=>true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error"=>"DB error: ".$e->getMessage()]);
}
