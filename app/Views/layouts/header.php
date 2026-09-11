<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($settings['site_name'] ?? 'NEXTRASTORE') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    
    <style>
        :root {
            --bg-color: <?= $settings['color_bg'] ?? '#000000' ?>;
            --card-bg: <?= $settings['color_card_bg'] ?? '#080808' ?>;
            --primary-color: <?= $settings['color_primary'] ?? '#1877f2' ?>;
            --btn-buy-start: <?= $settings['color_btn_buy_start'] ?? '#51aed9' ?>;
            --btn-buy-end: <?= $settings['color_btn_buy_end'] ?? '#358bb5' ?>;
        }
        body { background-color: var(--bg-color); }
        .product-card { background-color: var(--card-bg); }
        .marquee-text-inner { animation-duration: <?= $settings['marquee_speed'] ?? '22' ?>s; }
    </style>
    
    <style><?= $settings['custom_css'] ?? '' ?></style>
    <?= $settings['custom_js'] ?? '' ?>
</head>
<body>

<?php if (($settings['marquee_enabled'] ?? '1') === '1'): ?>
<div class="marquee-container">
    <div class="marquee-text-inner">
        <i class="fa-solid fa-bullhorn icon-highlight"></i> 
        <?= htmlspecialchars($settings['marquee_text'] ?? 'ยินดีต้อนรับสู่ NEXTRASTORE!') ?>
    </div>
</div>
<?php endif; ?>

<header class="main-header">
    <div class="header-container">
        <a href="/" class="logo-title">
            <i class="fa-solid fa-bolt-lightning logo-icon"></i>
            <?= htmlspecialchars($settings['site_name'] ?? 'NEXTRASTORE') ?>
        </a>
        <nav class="main-nav">
            <a href="/" class="nav-link"><i class="fa-solid fa-house"></i> หน้าหลัก</a>
            <a href="/#products" class="nav-link"><i class="fa-solid fa-bag-shopping"></i> สินค้า</a>
            <a href="/topup" class="nav-link"><i class="fa-solid fa-credit-card"></i> เติมเงิน</a>
            <a href="/admin" class="nav-link" style="color: #ef4444;"><i class="fa-solid fa-sliders"></i> หลังบ้าน</a>
        </nav>
        <div class="wallet-badge">
            <i class="fa-solid fa-wallet"></i> ฿<?= htmlspecialchars(number_format($user['balance'] ?? 0, 2)) ?>
        </div>
    </div>
</header>
