<?php

header("Content-Type: application/json");

require_once __DIR__ . '/../../Database.php';   // ← same logic
require_once __DIR__ . '/TaskDao.php';

$database = new Database();
$conn = $database->getConnection();
$taskDao = new TaskDao($conn);

try {
    $tasks = $taskDao->getTasks();
    echo json_encode($tasks);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
