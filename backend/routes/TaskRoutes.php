<?php
require_once __DIR__ . '/../services/TaskService.php';

$taskService = new TaskService();

/**
 * @OA\Get(
 *   path="/tasks",
 *   tags={"Tasks"},
 *   summary="Get all tasks",
 *   @OA\Response(response=200, description="List all tasks")
 * )
 */
Flight::route('GET /tasks', function() use($taskService) {
    Flight::json($taskService->get_all_tasks());
});

// CORS preflight for _any_ endpoint
Flight::route('OPTIONS /tasks(/.*)?', function() {
    // you can also send CORS headers here if needed
    Flight::halt(200);
  });

/**
 * @OA\Get(
 *   path="/tasks/{id}",
 *   tags={"Tasks"},
 *   summary="Get one task",
 *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *   @OA\Response(response=200, description="Task object"),
 *   @OA\Response(response=404, description="Not found")
 * )
 */
Flight::route('GET /tasks/@id', function($id) use($taskService) {
    $task = $taskService->get_task_by_id((int)$id);
    if ($task) {
        Flight::json($task);
    } else {
        Flight::halt(404, json_encode(['error'=>'Task not found']));
    }
});

/**
 * @OA\Post(
 *   path="/tasks",
 *   tags={"Tasks"},
 *   summary="Create a task",
 *   @OA\RequestBody(@OA\JsonContent(required={"title"}, @OA\Property(property="title", type="string"), @OA\Property(property="description", type="string"))),
 *   @OA\Response(response=200, description="ID of new task")
 * )
 */
Flight::route('POST /tasks', function() use($taskService) {
    // CORS pre-flight
    if ($_SERVER['REQUEST_METHOD']==='OPTIONS') Flight::halt(200);
    $in = Flight::request()->data->getData();
    if (empty($in['title'])) Flight::halt(400, json_encode(['error'=>'Missing title']));
    $id = $taskService->create_task($in);
    Flight::json(['success'=>true,'id'=>$id]);
});

/**
 * @OA\Put(
 *   path="/tasks/{id}",
 *   tags={"Tasks"},
 *   summary="Update a task",
 *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *   @OA\RequestBody(@OA\JsonContent(@OA\Property(property="title", type="string"), @OA\Property(property="description", type="string"))),
 *   @OA\Response(response=200, description="Success")
 * )
 */
Flight::route('PUT /tasks/@id', function($id) use($taskService) {
    $data = Flight::request()->data->getData();
    $taskService->update_task((int)$id, $data);
    Flight::json(['success'=>true]);
});

/**
 * @OA\Delete(
 *   path="/tasks/{id}",
 *   tags={"Tasks"},
 *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *   @OA\Response(response=200, description="Task deleted")
 * )
 */
Flight::route('DELETE /tasks/@id', function($id) use($taskService) {
    $taskService->delete_task((int)$id);
    Flight::json(['success'=>true]);
});
