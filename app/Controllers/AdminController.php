<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Product;
use App\Models\Setting;

class AdminController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['user'] = ['username' => '@admin9098', 'role' => 'admin'];
        }
    }

    public function dashboard(): void {
        $productModel = new Product();
        $settingModel = new Setting();

        $this->render('admin/dashboard', [
            'adminName' => $_SESSION['user']['username'] ?? '@admin9098',
            'products'  => $productModel->getAllWithDurations(),
            'settings'  => $settingModel->getAll()
        ]);
    }

    public function updateSettings(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settingModel = new Setting();
            foreach ($_POST as $key => $value) {
                $settingModel->updateKey($key, $value);
            }
        }
        header('Location: /admin?status=settings_updated');
        exit;
    }

    public function storeProduct(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name           = $_POST['name'] ?? '';
            $image          = $_POST['image'] ?? '';
            $stock          = intval($_POST['stock'] ?? -1);
            $durationValues = $_POST['duration_values'] ?? [];
            $timeUnits      = $_POST['time_units'] ?? [];
            $prices         = $_POST['prices'] ?? [];

            if (!empty($name) && !empty($durationValues)) {
                $productModel = new Product();
                $productModel->saveWithDurations($name, $image, $stock, $durationValues, $timeUnits, $prices);
            }
        }
        header('Location: /admin?status=product_added');
        exit;
    }

    public function deleteProduct(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            if ($id > 0) {
                $productModel = new Product();
                $productModel->delete($id);
            }
        }
        header('Location: /admin?status=product_deleted');
        exit;
    }
}
