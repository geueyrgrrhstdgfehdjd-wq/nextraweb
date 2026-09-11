<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<main class="container">
    <section id="products" class="popular-section">
        <div class="section-header-box">
            <h1 class="popular-title"><?= htmlspecialchars($settings['popular_title'] ?? 'Popular') ?></h1>
            <button class="btn-all-items">
                <i class="fa-solid fa-layer-group"></i> 
                ดูทั้งหมด <?= count($products ?? []) ?> รายการ
            </button>
        </div>

        <div class="product-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-image-box">
                            <img src="<?= htmlspecialchars($product['image'] ?? '/assets/images/default.jpg') ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        </div>
                        <div class="product-info">
                            <div class="product-stock">
                                <i class="fa-solid fa-boxes-stacked"></i> สต็อก: <?= ($product['stock'] ?? -1) >= 0 ? "เหลือ {$product['stock']} ชิ้น" : 'ไม่จำกัด' ?>
                            </div>
                            <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
                            
                            <!-- ตัวเลือกระยะเวลาเช่า/ใช้งาน (ชั่วโมง/วัน) -->
                            <?php if (!empty($product['durations'])): ?>
                                <div style="margin: 10px 0;">
                                    <label style="font-size: 0.8rem; color: #a1a1aa;"><i class="fa-solid fa-clock"></i> เลือกระยะเวลาการใช้งาน:</label>
                                    <select class="duration-selector" onchange="updatePriceDisplay(this)" style="width: 100%; background: #121212; color: #fff; padding: 8px 10px; border-radius: 8px; border: 1px solid #27272a; margin-top: 4px; font-family: 'Prompt', sans-serif;">
                                        <?php foreach ($product['durations'] as $d): ?>
                                            <?php $unitText = ($d['time_unit'] === 'hour') ? 'ชั่วโมง' : 'วัน'; ?>
                                            <option value="<?= $d['price'] ?>">
                                                <?= $d['duration_value'] ?> <?= $unitText ?> — <?= number_format($d['price'], 2) ?> บาท
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>

                            <!-- แสดงราคาปัจจุบัน -->
                            <div class="price-display" style="font-size: 1.1rem; font-weight: 800; color: #38bdf8; margin-bottom: 12px;">
                                ราคา: <span><?= number_format($product['durations'][0]['price'] ?? $product['price'], 2) ?></span> บาท
                            </div>

                            <button class="btn-buy-now">
                                <i class="fa-solid fa-cart-shopping"></i> ซื้อทันที
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #a1a1aa; text-align: center; grid-column: 1 / -1;">ยังไม่มีสินค้าในขณะนี้</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
function updatePriceDisplay(selectEl) {
    const price = parseFloat(selectEl.value).toFixed(2);
    const card = selectEl.closest('.product-card');
    card.querySelector('.price-display span').innerText = price;
}
</script>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
