<?php
require_once __DIR__ . '/../BaseDao.php';

class FriendDao extends BaseDao {
    public function __construct($conn) {
        parent::__construct($conn);
    }

    public function getAllFriends() {
        return $this->select("friends", "created_at DESC");
    }

    public function getFriendship($user_id, $friend_id) {
        $stmt = $this->executeQuery(
            "SELECT * FROM friends WHERE user_id = :user_id AND friend_id = :friend_id",
            ['user_id' => $user_id, 'friend_id' => $friend_id]
        );
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createFriendship($user_id, $friend_id) {
        $this->executeQuery(
            "INSERT INTO friends (user_id, friend_id) VALUES (:user_id, :friend_id)",
            ['user_id' => $user_id, 'friend_id' => $friend_id]
        );
    }

    public function deleteFriendship($user_id, $friend_id) {
        $this->executeQuery(
            "DELETE FROM friends WHERE user_id = :user_id AND friend_id = :friend_id",
            ['user_id' => $user_id, 'friend_id' => $friend_id]
        );
    }
}
?>
