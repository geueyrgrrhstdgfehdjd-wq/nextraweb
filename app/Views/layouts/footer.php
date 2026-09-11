    <section class="store-footer-banner">
        <div class="container">
            <h1 class="footer-title"><?= htmlspecialchars($settings['footer_title'] ?? 'NEXTRASTORE') ?></h1>
            <p class="footer-subtitle">
                <i class="fa-solid fa-shield-halved"></i> 
                <?= htmlspecialchars($settings['footer_subtitle'] ?? 'สินค้าปลอดภัยมีแอดมินบริการ 24 ชม.') ?>
            </p>
            
            <div class="footer-actions">
                <a href="<?= htmlspecialchars($settings['footer_btn1_url'] ?? '/#products') ?>" class="btn-action primary-action">
                    <i class="fa-solid fa-store"></i> 
                    <?= htmlspecialchars($settings['footer_btn1_text'] ?? 'เลือกดูสินค้า') ?>
                </a>
                <a href="<?= htmlspecialchars($settings['footer_btn2_url'] ?? '#history') ?>" class="btn-action secondary-action">
                    <i class="fa-solid fa-magnifying-glass"></i> 
                    <?= htmlspecialchars($settings['footer_btn2_text'] ?? 'ตรวจสอบการซื้อ') ?>
                </a>
            </div>
        </div>
    </section>

    <footer class="footer-copyright">
        <p><?= htmlspecialchars($settings['copyright_text'] ?? '© 2026 NEXTRASTORE Platform. All rights reserved.') ?></p>
    </footer>

    <script src="/assets/js/main.js"></script>
</body>
</html>
