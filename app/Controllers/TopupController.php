<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Setting;
use App\Models\User;
use App\Services\TrueMoneyService;

class TopupController extends Controller {
    public function index(): void {
        $settingModel = new Setting();
        $userModel = new User();

        $this->render('topup/index', [
            'settings' => $settingModel->getAll(),
            'user'     => $userModel->getUserInfo($_SESSION['user_id'] ?? 1)
        ]);
    }

    public function processTruemoney(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['status' => false, 'message' => 'Invalid Method']);
        }

        $voucherUrl = $_POST['voucher_url'] ?? '';
        if (empty($voucherUrl)) {
            $this->json(['status' => false, 'message' => 'กรุณากรอกลิงก์ซองอั่งเปา TrueMoney']);
        }

        $truemoney = new TrueMoneyService();
        $result = $truemoney->redeemVoucher($voucherUrl);

        if (isset($result['status']) && ($result['status'] === true || $result['status'] === 'success')) {
            $amount = floatval($result['amount'] ?? $result['data']['amount'] ?? 0);
            $userId = $_SESSION['user_id'] ?? 1;

            if ($amount > 0) {
                $userModel = new User();
                $userModel->addBalance($userId, $amount);
                $this->json(['status' => true, 'message' => "เติมเงินสำเร็จเรียบร้อยแล้ว จำนวน {$amount} บาท"]);
            }
        }

        $msg = $result['message'] ?? 'ไม่สามารถเติมเงินได้ ลิงก์ซองอาจถูกใช้งานไปแล้ว';
        $this->json(['status' => false, 'message' => $msg]);
    }
}
