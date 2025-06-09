<?php
// backend/dao/forms/submitForm.php

// CORS & JSON headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit(0);

header("Content-Type: application/json");

// enforce POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Invalid method"]);
    exit;
}

// read JSON body
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

// validate
if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["field"=>"email","msg"=>"Valid email required"]);
    exit;
}
if (empty($data['password']) || strlen($data['password']) < 8) {
    http_response_code(400);
    echo json_encode(["field"=>"password","msg"=>"Password must be ≥8 chars"]);
    exit;
}
if (!isset($data['confirm']) || $data['password'] !== $data['confirm']) {
    http_response_code(400);
    echo json_encode(["field"=>"confirm","msg"=>"Passwords must match"]);
    exit;
}
if (empty($data['terms']) || $data['terms'] !== true) {
    http_response_code(400);
    echo json_encode(["field"=>"terms","msg"=>"You must accept terms"]);
    exit;
}

// sanitize & hash
$email    = htmlspecialchars(trim($data['email']), ENT_QUOTES);
$hash     = password_hash($data['password'], PASSWORD_DEFAULT);

// save to DB (example using your Database() & PDO)
require_once __DIR__ . '/../../Database.php';
$db  = new Database();
$pdo = $db->getConnection();

try {
    $stmt = $pdo->prepare("
      INSERT INTO users (email,password)
      VALUES (:email,:password)
    ");
    $stmt->execute([
      ':email'    => $email,
      ':password' => $hash
    ]);
    http_response_code(201);
    echo json_encode(["success"=>true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error"=>"Server error"]);
}
