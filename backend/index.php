<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../Database.php';   // ← goes up from dao/tasks/
require_once __DIR__ . '/../BaseDao.php';       // ← goes up to dao/

// GET all tasks
Flight::route('GET /tasks', function() {
    $db = new Database();
    $conn = $db->getConnection();
    $dao = new TaskDao($conn);
    Flight::json($dao->getTasks());
});

// GET one task by ID
Flight::route('GET /tasks/@id', function($id) {
    $db = new Database();
    $conn = $db->getConnection();
    $dao = new TaskDao($conn);
    Flight::json($dao->getTaskById($id));
});

// CREATE new task
Flight::route('POST /tasks', function() {
    $data = Flight::request()->data;
    $db = new Database();
    $conn = $db->getConnection();
    $dao = new TaskDao($conn);
    $dao->createTask($data['title'], $data['description']);
    Flight::json(['success' => true]);
});

// UPDATE a task
Flight::route('PUT /tasks/@id', function($id) {
    $data = Flight::request()->data;
    $db = new Database();
    $conn = $db->getConnection();
    $dao = new TaskDao($conn);
    $dao->updateTask($id, $data['title'], $data['description']);
    Flight::json(['success' => true]);
});

// DELETE a task
Flight::route('DELETE /tasks/@id', function($id) {
    $db = new Database();
    $conn = $db->getConnection();
    $dao = new TaskDao($conn);
    $dao->deleteTask($id);
    Flight::json(['success' => true]);
});

Flight::start();
