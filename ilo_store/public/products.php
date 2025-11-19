<?php
require_once __DIR__ . '/../includes/functions.php';

$products = get_all_products();

// تضمين ملف الرأس (Header)
include __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>جميع المنتجات</h1>
    
    <!-- قسم الفلترة والترتيب (لتبسيط المشروع، سنعرض فقط المنتجات) -->
    <div class="filter-sort-bar">
        <!-- يمكن إضافة فلاتر هنا لاحقاً -->
        <p>عرض <?= count($products) ?> منتج</p>
    </div>

    <section class="product-list">
        <div class="product-grid">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="price"><?= number_format($product['price'], 2) ?> ر.س</p>
                        <a href="product.php?id=<?= $product['id'] ?>" class="btn-primary">عرض التفاصيل</a>
                        <button class="btn-secondary add-to-cart" data-product-id="<?= $product['id'] ?>">أضف للسلة</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>لا توجد منتجات متاحة حالياً.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
// تضمين ملف التذييل (Footer)
include __DIR__ . '/../includes/footer.php';
?>
