<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<main class="container" style="max-width: 600px; padding: 40px 15px;">
    <div style="background: #080808; border: 1px solid #1f1f1f; border-radius: 16px; padding: 30px;">
        <h2 style="font-size: 1.5rem; color: #fff; margin-bottom: 8px; text-align: center;">
            <i class="fa-solid fa-wallet" style="color: #ef4444;"></i> เติมเงินด้วยซองอั่งเปา TrueMoney
        </h2>
        <p style="color: #71717a; font-size: 0.9rem; text-align: center; margin-bottom: 25px;">
            สร้างซองอั่งเปาแบบแบ่งเท่ากัน และนำลิงก์มาวางเพื่อเติมเงิน
        </p>

        <form id="topup-form">
            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #38bdf8; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600;">
                    <i class="fa-solid fa-link"></i> ลิงก์ซองอั่งเปา TrueMoney
                </label>
                <input type="url" id="voucher_url" name="voucher_url" placeholder="https://gift.truemoney.com/v1/gift?v=xxx" 
                       style="width: 100%; background: #121212; border: 1px solid #27272a; color: #fff; padding: 12px 16px; border-radius: 10px; font-size: 0.95rem; font-family: 'Prompt', sans-serif;" required>
            </div>

            <button type="submit" id="btn-submit-topup" class="btn-buy-now" style="width: 100%; padding: 14px; border-radius: 10px; font-size: 1rem;">
                <i class="fa-solid fa-circle-check"></i> ยืนยันการเติมเงิน
            </button>
        </form>

        <div id="topup-result" style="margin-top: 15px; text-align: center; font-size: 0.95rem;"></div>
    </div>
</main>

<script>
document.getElementById('topup-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('btn-submit-topup');
    const resultDiv = document.getElementById('topup-result');
    const voucherUrl = document.getElementById('voucher_url').value;

    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> กำลังตรวจสอบซอง...';
    resultDiv.innerHTML = '';

    const formData = new FormData();
    formData.append('voucher_url', voucherUrl);

    fetch('/topup/truemoney', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status) {
            resultDiv.innerHTML = `<span style="color: #22c55e;"><i class="fa-solid fa-circle-check"></i> ${data.message}</span>`;
            setTimeout(() => location.reload(), 2000);
        } else {
            resultDiv.innerHTML = `<span style="color: #ef4444;"><i class="fa-solid fa-circle-xmark"></i> ${data.message}</span>`;
        }
    })
    .catch(() => {
        resultDiv.innerHTML = '<span style="color: #ef4444;"><i class="fa-solid fa-circle-xmark"></i> เกิดข้อผิดพลาดในระบบ</span>';
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-circle-check"></i> ยืนยันการเติมเงิน';
    });
});
</script>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
