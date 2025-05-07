<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!isset($data['id']) || !isset($data['title'])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing id or title!"]);
        exit;
    }
    
    $id = intval($data['id']);
    $title = trim($data['title']);
    $description = isset($data['description']) ? trim($data['description']) : "";

    if (empty($title)) {
        http_response_code(400);
        echo json_encode(["error" => "Please fill in the Title field!"]);
        exit;
    }

    require_once __DIR__ . '/../../Database.php';   // ← same logic
    require_once __DIR__ . '/TaskDao.php';

    $database = new Database();
    $conn = $database->getConnection();
    $taskDao = new TaskDao($conn);

    try {
        $result = $taskDao->updateTask($id, $title, $description);
        if ($result) {
            echo json_encode(["success" => true, "message" => "Task updated successfully!"]);
        } else {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Failed to update task."]);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Error: " . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Invalid request method."]);
}
?>
