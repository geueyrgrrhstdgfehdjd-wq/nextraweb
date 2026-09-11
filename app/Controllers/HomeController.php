<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;

class HomeController extends Controller {
    public function index(): void {
        $productModel = new Product();
        $settingModel = new Setting();
        $userModel = new User();

        $this->render('home/index', [
            'products' => $productModel->getAllWithDurations(),
            'settings' => $settingModel->getAll(),
            'user'     => $userModel->getUserInfo($_SESSION['user_id'] ?? 1)
        ]);
    }
}
