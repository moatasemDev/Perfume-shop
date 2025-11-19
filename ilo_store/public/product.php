<?php
require_once __DIR__ . '/../includes/functions.php';

$product_id = $_GET['id'] ?? 0;
$product = get_product_by_id($product_id);

if (!$product) {
    header("location: products.php");
    exit;
}

$reviews = get_product_reviews($product_id);

// تضمين ملف الرأس (Header)
include __DIR__ . '/../includes/header.php';
?>

<main>
    <section class="product-details">
        <div class="product-image">
            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            <!-- يمكن إضافة معرض صور هنا -->
        </div>
        <div class="product-info">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            <p class="price"><?= number_format($product['price'], 2) ?> ر.س</p>
            
            <div class="description">
                <h3>الوصف</h3>
                <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            </div>

            <div class="specs">
                <h3>المواصفات</h3>
                <ul>
                    <li><strong>الحجم:</strong> <?= htmlspecialchars($product['size']) ?></li>
                    <li><strong>الفئة:</strong> <?= htmlspecialchars($product['category']) ?></li>
                    <li><strong>نوع الرائحة:</strong> <?= htmlspecialchars($product['scent_type']) ?></li>
                    <li><strong>العلامة التجارية:</strong> <?= htmlspecialchars($product['brand']) ?></li>
                </ul>
            </div>

            <form action="cart_action.php" method="POST" class="add-to-cart-form">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <label for="quantity">الكمية:</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $product['stock_quantity'] ?>" required>
                <button type="submit" class="btn-primary">أضف للسلة</button>
            </form>
        </div>
    </section>

    <section class="product-reviews">
        <h2>تقييمات العملاء (<?= count($reviews) ?>)</h2>
        <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
            <!-- نموذج إضافة تقييم -->
            <form action="add_review.php" method="POST" class="review-form">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <label for="rating">التقييم (1-5):</label>
                <input type="number" id="rating" name="rating" min="1" max="5" required>
                <label for="comment">التعليق:</label>
                <textarea id="comment" name="comment" rows="4" required></textarea>
                <button type="submit" class="btn-secondary">إرسال التقييم</button>
            </form>
        <?php else: ?>
            <p>يرجى <a href="login.php">تسجيل الدخول</a> لإضافة تقييمك.</p>
        <?php endif; ?>

        <div class="reviews-list">
            <?php if (count($reviews) > 0): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item">
                        <p><strong><?= htmlspecialchars($review['username']) ?></strong> - تقييم: <?= str_repeat('⭐', $review['rating']) ?></p>
                        <p><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                        <small>بتاريخ: <?= date('Y-m-d', strtotime($review['created_at'])) ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>لا توجد تقييمات لهذا المنتج بعد.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
// تضمين ملف التذييل (Footer)
include __DIR__ . '/../includes/footer.php';
?>
