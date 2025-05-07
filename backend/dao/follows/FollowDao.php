<?php
require_once __DIR__ . '/../BaseDao.php';

class FollowDao extends BaseDao {
    public function __construct($conn) {
        parent::__construct($conn);
    }

    public function getAllFollows() {
        return $this->select("follows", "created_at DESC");
    }

    public function getFollow($follower_id, $followed_id) {
        $stmt = $this->executeQuery(
            "SELECT * FROM follows WHERE following_user_id = :follower AND followed_user_id = :followed",
            ['follower' => $follower_id, 'followed' => $followed_id]
        );
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createFollow($follower_id, $followed_id) {
        $this->executeQuery(
            "INSERT INTO follows (following_user_id, followed_user_id) VALUES (:follower, :followed)",
            ['follower' => $follower_id, 'followed' => $followed_id]
        );
    }

    public function deleteFollow($follower_id, $followed_id) {
        $this->executeQuery(
            "DELETE FROM follows WHERE following_user_id = :follower AND followed_user_id = :followed",
            ['follower' => $follower_id, 'followed' => $followed_id]
        );
    }
}
?>
