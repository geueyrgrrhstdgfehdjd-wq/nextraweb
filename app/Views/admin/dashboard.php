<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ultimate Admin Panel - NEXTRASTORE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background: #000; color: #fff; font-family: 'Prompt', sans-serif; margin: 0; padding: 0; }
        .admin-wrapper { max-width: 1400px; margin: 0 auto; padding: 30px 20px; }
        .tab-menu { display: flex; gap: 8px; border-bottom: 2px solid #1f1f1f; margin-bottom: 25px; flex-wrap: wrap; }
        .tab-btn { background: #080808; border: 1px solid #1f1f1f; color: #a1a1aa; padding: 12px 20px; border-radius: 8px 8px 0 0; cursor: pointer; font-weight: 600; font-family: 'Prompt', sans-serif; }
        .tab-btn.active { background: #1877f2; color: #fff; border-color: #1877f2; }
        .tab-content { display: none; background: #080808; border: 1px solid #1f1f1f; padding: 25px; border-radius: 12px; }
        .tab-content.active { display: block; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 18px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label { color: #38bdf8; font-size: 0.9rem; font-weight: 600; }
        .form-group input, .form-group select, .form-group textarea { background: #121212; border: 1px solid #27272a; color: #fff; padding: 10px 14px; border-radius: 8px; font-size: 0.95rem; font-family: 'Prompt', sans-serif; }
        .form-group input[type="color"] { height: 42px; padding: 4px; cursor: pointer; }
        .btn-submit { background: #22c55e; color: #000; border: none; padding: 14px 28px; border-radius: 8px; font-weight: bold; font-size: 1rem; cursor: pointer; margin-top: 20px; font-family: 'Prompt', sans-serif; }
        .product-list-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .product-list-table th, .product-list-table td { padding: 12px; border: 1px solid #1f1f1f; text-align: left; font-size: 0.9rem; }
        .product-list-table th { background: #121212; color: #38bdf8; }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #1f1f1f; padding-bottom: 15px;">
        <h1 style="font-size: 1.8rem; margin: 0; color: #1877f2;"><i class="fa-solid fa-sliders"></i> NEXTRASTORE Full Control Panel</h1>
        <div>แอดมิน: <strong style="color: #38bdf8;"><?= htmlspecialchars($adminName) ?></strong> | <a href="/" style="color: #a1a1aa; text-decoration: none;">ดูหน้าบ้าน</a></div>
    </div>

    <div class="tab-menu">
        <button type="button" class="tab-btn active" onclick="switchTab(event, 'tab-products')"><i class="fa-solid fa-box-open"></i> จัดการสินค้า & เวลา</button>
        <button type="button" class="tab-btn" onclick="switchTab(event, 'tab-general')"><i class="fa-solid fa-globe"></i> ทั่วไป & SEO</button>
        <button type="button" class="tab-btn" onclick="switchTab(event, 'tab-theme')"><i class="fa-solid fa-palette"></i> สี & ธีมหน้าบ้าน</button>
        <button type="button" class="tab-btn" onclick="switchTab(event, 'tab-header')"><i class="fa-solid fa-bullhorn"></i> ข้อความวิ่ง</button>
        <button type="button" class="tab-btn" onclick="switchTab(event, 'tab-footer')"><i class="fa-solid fa-shoe-prints"></i> Footer & ปุ่มล่าง</button>
        <button type="button" class="tab-btn" onclick="switchTab(event, 'tab-code')"><i class="fa-solid fa-code"></i> Custom CSS / JS</button>
    </div>

    <!-- TAB 1: จัดการสินค้าแบบกำหนดชั่วโมง/วันอิสระ -->
    <div id="tab-products" class="tab-content active">
        <div style="background: #0d0d0d; border: 1px solid #1f1f1f; padding: 20px; border-radius: 12px;">
            <h3 style="color: #38bdf8; margin-top: 0;"><i class="fa-solid fa-plus-circle"></i> เพิ่มสินค้าใหม่ (กำหนดชั่วโมง/วัน และราคาได้อิสระ)</h3>
            
            <form action="/admin/product/store" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label>ชื่อสินค้า</label>
                        <input type="text" name="name" placeholder="เช่น ไอดี VIP / เช่าโปรแกรม" required>
                    </div>
                    <div class="form-group">
                        <label>ลิงก์รูปภาพ</label>
                        <input type="url" name="image" placeholder="https://..." required>
                    </div>
                    <div class="form-group">
                        <label>จำนวนสต็อก (-1 คือไม่จำกัด)</label>
                        <input type="number" name="stock" value="-1" required>
                    </div>
                </div>

                <!-- โซนไดนามิก: ปุ่มเพิ่มแพ็กเกจเวลา -->
                <div style="margin-top: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <label style="color: #22c55e; font-weight: 600;"><i class="fa-solid fa-clock"></i> กำหนดช่วงเวลา (ชั่วโมง/วัน) และราคา</label>
                        <button type="button" onclick="addDurationRow()" style="background: #38bdf8; color: #000; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer; font-family: 'Prompt', sans-serif;">
                            <i class="fa-solid fa-plus"></i> เพิ่มแพ็กเกจเวลา
                        </button>
                    </div>

                    <div id="duration-list" style="display: flex; flex-direction: column; gap: 10px;"></div>
                </div>

                <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> บันทึกเพิ่มสินค้า</button>
            </form>
        </div>

        <!-- รายการสินค้าทั้งหมด -->
        <h3 style="color: #fff; margin-top: 30px;"><i class="fa-solid fa-list"></i> รายการสินค้าในระบบ</h3>
        <table class="product-list-table">
            <thead>
                <tr>
                    <th>รูป</th>
                    <th>ชื่อสินค้า</th>
                    <th>แพ็กเกจเวลา & ราคาที่มี</th>
                    <th>สต็อก</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($p['image']) ?>" width="40" height="40" style="border-radius: 6px; object-fit: cover;"></td>
                            <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>
                            <td>
                                <?php foreach ($p['durations'] as $d): ?>
                                    <span style="display: inline-block; background: #1f1f1f; padding: 3px 8px; border-radius: 4px; font-size: 0.8rem; margin-right: 4px; margin-bottom: 4px; color: #eab308;">
                                        <?= $d['duration_value'] ?> <?= $d['time_unit'] === 'hour' ? 'ชั่วโมง' : 'วัน' ?> = <?= number_format($d['price'], 2) ?>฿
                                    </span>
                                <?php endforeach; ?>
                            </td>
                            <td><?= $p['stock'] >= 0 ? $p['stock'] : 'ไม่จำกัด' ?></td>
                            <td>
                                <form action="/admin/product/delete" method="POST" onsubmit="return confirm('ยืนยันลบสินค้านี้?');">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <button type="submit" style="background: #ef4444; color: #fff; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer;"><i class="fa-solid fa-trash"></i> ลบ</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- TAB ตั้งค่าอื่นๆ -->
    <form action="/admin/settings/update" method="POST">
        <div id="tab-general" class="tab-content">
            <div class="form-grid">
                <div class="form-group">
                    <label>ชื่อร้านค้า (Site Name)</label>
                    <input type="text" name="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>">
                </div>
                <div class="form-group full">
                    <label>คำอธิบายติด SEO (Meta Description)</label>
                    <textarea name="meta_description" rows="3"><?= htmlspecialchars($settings['meta_description'] ?? '') ?></textarea>
                </div>
            </div>
            <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> บันทึกการตั้งค่า</button>
        </div>

        <div id="tab-theme" class="tab-content">
            <div class="form-grid">
                <div class="form-group">
                    <label>สีพื้นหลังหน้าเว็บ</label>
                    <input type="color" name="color_bg" value="<?= $settings['color_bg'] ?? '#000000' ?>">
                </div>
                <div class="form-group">
                    <label>สีพื้นหลังการ์ดสินค้า</label>
                    <input type="color" name="color_card_bg" value="<?= $settings['color_card_bg'] ?? '#080808' ?>">
                </div>
                <div class="form-group">
                    <label>สีไฮไลต์หลัก</label>
                    <input type="color" name="color_primary" value="<?= $settings['color_primary'] ?? '#1877f2' ?>">
                </div>
                <div class="form-group">
                    <label>สีปุ่มซื้อสินค้า (Gradient Top)</label>
                    <input type="color" name="color_btn_buy_start" value="<?= $settings['color_btn_buy_start'] ?? '#51aed9' ?>">
                </div>
                <div class="form-group">
                    <label>สีปุ่มซื้อสินค้า (Gradient Bottom)</label>
                    <input type="color" name="color_btn_buy_end" value="<?= $settings['color_btn_buy_end'] ?? '#358bb5' ?>">
                </div>
            </div>
            <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> บันทึกการตั้งค่า</button>
        </div>

        <div id="tab-header" class="tab-content">
            <div class="form-grid">
                <div class="form-group">
                    <label>เปิด/ปิด แถบข้อความวิ่ง</label>
                    <select name="marquee_enabled">
                        <option value="1" <?= ($settings['marquee_enabled'] ?? '1') === '1' ? 'selected' : '' ?>>เปิดใช้งาน</option>
                        <option value="0" <?= ($settings['marquee_enabled'] ?? '1') === '0' ? 'selected' : '' ?>>ปิดใช้งาน</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>ความเร็วการวิ่ง (วินาที/รอบ)</label>
                    <input type="number" name="marquee_speed" value="<?= $settings['marquee_speed'] ?? '22' ?>">
                </div>
                <div class="form-group full">
                    <label>ข้อความวิ่งประกาศ (Marquee Text)</label>
                    <input type="text" name="marquee_text" value="<?= htmlspecialchars($settings['marquee_text'] ?? '') ?>">
                </div>
            </div>
            <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> บันทึกการตั้งค่า</button>
        </div>

        <div id="tab-footer" class="tab-content">
            <div class="form-grid">
                <div class="form-group">
                    <label>หัวข้อ Footer Banner</label>
                    <input type="text" name="footer_title" value="<?= htmlspecialchars($settings['footer_title'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>คำอธิบาย Footer Banner</label>
                    <input type="text" name="footer_subtitle" value="<?= htmlspecialchars($settings['footer_subtitle'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>ปุ่มที่ 1: ข้อความ</label>
                    <input type="text" name="footer_btn1_text" value="<?= htmlspecialchars($settings['footer_btn1_text'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>ปุ่มที่ 1: ลิงก์</label>
                    <input type="text" name="footer_btn1_url" value="<?= htmlspecialchars($settings['footer_btn1_url'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>ปุ่มที่ 2: ข้อความ</label>
                    <input type="text" name="footer_btn2_text" value="<?= htmlspecialchars($settings['footer_btn2_text'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>ปุ่มที่ 2: ลิงก์</label>
                    <input type="text" name="footer_btn2_url" value="<?= htmlspecialchars($settings['footer_btn2_url'] ?? '') ?>">
                </div>
                <div class="form-group full">
                    <label>ข้อความ Copyright ท้ายสุด</label>
                    <input type="text" name="copyright_text" value="<?= htmlspecialchars($settings['copyright_text'] ?? '') ?>">
                </div>
            </div>
            <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> บันทึกการตั้งค่า</button>
        </div>

        <div id="tab-code" class="tab-content">
            <div class="form-grid">
                <div class="form-group full">
                    <label>Custom CSS</label>
                    <textarea name="custom_css" rows="5"><?= htmlspecialchars($settings['custom_css'] ?? '') ?></textarea>
                </div>
                <div class="form-group full">
                    <label>Custom JavaScript</label>
                    <textarea name="custom_js" rows="5"><?= htmlspecialchars($settings['custom_js'] ?? '') ?></textarea>
                </div>
            </div>
            <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> บันทึกการตั้งค่า</button>
        </div>
    </form>
</div>

<script>
function switchTab(e, tabId) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    e.currentTarget.classList.add('active');
}

// สคริปต์ไดนามิกเพิ่มแถวแพ็กเกจเวลา
function addDurationRow(value = '', unit = 'hour', price = '') {
    const container = document.getElementById('duration-list');
    const rowId = Date.now() + Math.random().toString(36).substr(2, 5);
    
    const div = document.createElement('div');
    div.id = `row-${rowId}`;
    div.style.cssText = 'display: flex; gap: 10px; align-items: center; background: #121212; padding: 10px; border-radius: 8px; border: 1px solid #27272a;';
    
    div.innerHTML = `
        <div style="flex: 1;">
            <input type="number" name="duration_values[]" value="${value}" placeholder="จำนวนเวลา (เช่น 12 หรือ 7)" required style="width: 100%;">
        </div>
        <div style="width: 140px;">
            <select name="time_units[]" style="width: 100%;">
                <option value="hour" ${unit === 'hour' ? 'selected' : ''}>ชั่วโมง</option>
                <option value="day" ${unit === 'day' ? 'selected' : ''}>วัน</option>
            </select>
        </div>
        <div style="flex: 1;">
            <input type="number" step="0.01" name="prices[]" value="${price}" placeholder="ราคา (บาท)" required style="width: 100%;">
        </div>
        <button type="button" onclick="document.getElementById('row-${rowId}').remove()" style="background: #ef4444; color: #fff; border: none; padding: 10px 14px; border-radius: 6px; cursor: pointer;">
            <i class="fa-solid fa-trash"></i>
        </button>
    `;
    container.appendChild(div);
}

// สร้าง 2 แถวแรกเป็นตัวอย่างเมื่อโหลดหน้าเว็บ
window.addEventListener('DOMContentLoaded', () => {
    addDurationRow(12, 'hour', 50);
    addDurationRow(1, 'day', 90);
});
</script>
</body>
</html>
