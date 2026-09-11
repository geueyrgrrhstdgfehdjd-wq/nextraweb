<?php
namespace App\Models;

use Core\Database;

class Product extends Database {
    // บันทึกสินค้าพร้อมแพ็กเกจเวลาแบบยืดหยุ่น (ชั่วโมง/วัน + ราคา)
    public function saveWithDurations(string $name, string $image, int $stock, array $durationValues, array $timeUnits, array $prices): bool {
        $this->db->beginTransaction();
        try {
            $defaultPrice = floatval($prices[0] ?? 0);

            // 1. บันทึกข้อมูลหลักของสินค้า
            $stmt = $this->db->prepare("INSERT INTO products (name, image, price, stock) VALUES (:name, :image, :price, :stock)");
            $stmt->execute([
                'name'  => $name,
                'image' => $image,
                'price' => $defaultPrice,
                'stock' => $stock
            ]);
            $productId = $this->db->lastInsertId();

            // 2. บันทึกแพ็กเกจเวลาและราคาแต่ละช่วง
            $stmtDuration = $this->db->prepare("INSERT INTO product_duration_prices (product_id, duration_value, time_unit, price) VALUES (:product_id, :duration_value, :time_unit, :price)");
            
            for ($i = 0; $i < count($durationValues); $i++) {
                if (!empty($durationValues[$i]) && !empty($prices[$i])) {
                    $stmtDuration->execute([
                        'product_id'     => $productId,
                        'duration_value' => intval($durationValues[$i]),
                        'time_unit'      => $timeUnits[$i],
                        'price'          => floatval($prices[$i])
                    ]);
                }
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // ดึงรายการสินค้าพร้อมแพ็กเกจเวลาทั้งหมดสำหรับแสดงหน้าบ้านและหลังบ้าน
    public function getAllWithDurations(): array {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY id DESC");
        $products = $stmt->fetchAll() ?: [];

        foreach ($products as &$p) {
            $stmtD = $this->db->prepare("SELECT * FROM product_duration_prices WHERE product_id = :id ORDER BY time_unit ASC, duration_value ASC");
            $stmtD->execute(['id' => $p['id']]);
            $p['durations'] = $stmtD->fetchAll() ?: [];
        }

        return $products;
    }

    // ลบสินค้า
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
