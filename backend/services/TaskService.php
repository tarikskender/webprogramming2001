<?php
require_once __DIR__ . '/../dao/TaskDao.php';

class TaskService {
    public function get_all_tasks(): array {
        return (new TaskDao())->selectAll('created_at DESC');
    }

    public function get_task_by_id(int $id): ?array {
        return (new TaskDao())->selectById($id);
    }

    public function create_task(array $in): int {
        // pick a random placeholder image
        $dir  = __DIR__ . '/../../frontend/src/assets/images/tasks/';
        $imgs = glob($dir . 'task*.jpeg');
        $in['image_type'] = $imgs
          ? basename($imgs[array_rand($imgs)])
          : 'default.jpg';
        return (new TaskDao())->insert($in);
    }

    public function update_task(int $id, array $data): void {
        (new TaskDao())->update($id, $data);
    }

    public function delete_task(int $id): void {
        (new TaskDao())->delete($id);
    }
}
