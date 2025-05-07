<?php
// createTask.php

// Allowing all origins for development
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Read and decode JSON input
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Validate input
    if (!isset($data['title'])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing title!"]);
        exit;
    }
    
    $title = trim($data['title']);
    $description = isset($data['description']) ? trim($data['description']) : "";

    if (empty($title)) {
        http_response_code(400);
        echo json_encode(["error" => "Please fill in the Title field!"]);
        exit;
    }
    
    // Path to image folder
    $imageDir = __DIR__ . '/../../../frontend/src/assets/images/tasks/';

    // Get all task images
    $images = glob($imageDir . 'task*.jpeg');

    // If images are found, pick one randomly
    if ($images && count($images) > 0) {
    $randomImage = basename($images[array_rand($images)]);
    } else {
    $randomImage = 'default.jpg';
    }

    $imageType = $randomImage;

    require_once __DIR__ . '/../../Database.php';   // ← same logic
    require_once __DIR__ . '/TaskDao.php';

    $database = new Database();
    $conn = $database->getConnection();
    $taskDao = new TaskDao($conn);

    try {
        $result = $taskDao->createTask($title, $description, null, null, null, $imageType);
        if ($result) {
            echo json_encode(["success" => true, "message" => "Task created successfully!", "image" => $imageType]);
        } else {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Failed to create task."]);
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
