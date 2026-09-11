<?php
namespace App\Models;

use Core\Database;

class Setting extends Database {
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM site_settings");
        $results = $stmt->fetchAll() ?: [];
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    public function updateKey(string $key, string $value): void {
        $stmt = $this->db->prepare("INSERT INTO site_settings (setting_key, setting_value) 
                                    VALUES (:key, :value) 
                                    ON DUPLICATE KEY UPDATE setting_value = :value");
        $stmt->execute(['key' => $key, 'value' => $value]);
    }
}
