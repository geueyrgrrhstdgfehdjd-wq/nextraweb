<?php
namespace App\Models;

use Core\Database;

class User extends Database {
    public function getUserInfo(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function addBalance(int $userId, float $amount): bool {
        $stmt = $this->db->prepare("UPDATE users SET balance = balance + :amount WHERE id = :id");
        return $stmt->execute(['amount' => $amount, 'id' => $userId]);
    }
}
