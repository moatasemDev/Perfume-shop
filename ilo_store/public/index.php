<?php
require_once __DIR__ . '/../includes/functions.php';
session_start();

// جلب المنتجات والمقالات المميزة
$featured_products = get_featured_products();
$featured_articles = get_featured_articles();

// تضمين ملف الرأس (Header)
include __DIR__ . '/../includes/header.php';
?>

<main>
    <!-- قسم العروض والمنتجات المميزة -->
    <section class="featured-products">
        <h2>منتجاتنا المميزة</h2>
        <div class="product-grid">
            <?php foreach ($featured_products as $product): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="price"><?= number_format($product['price'], 2) ?> ر.س</p>
                    <a href="product.php?id=<?= $product['id'] ?>" class="btn-primary">عرض التفاصيل</a>
                    <button class="btn-secondary add-to-cart" data-product-id="<?= $product['id'] ?>">أضف للسلة</button>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="products.php" class="btn-link">شاهد جميع المنتجات</a>
    </section>

    <!-- قسم المقالات المختارة -->
    <section class="featured-articles">
        <h2>مقالات مختارة</h2>
        <div class="article-grid">
            <?php foreach ($featured_articles as $article): ?>
                <div class="article-card">
                    <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                    <h3><?= htmlspecialchars($article['title']) ?></h3>
                    <p class="category"><?= htmlspecialchars($article['category']) ?></p>
                    <a href="article.php?id=<?= $article['id'] ?>" class="btn-link">اقرأ المزيد</a>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="blog.php" class="btn-link">تصفح المدونة</a>
    </section>

    <!-- قسم العروض الخاصة / الخصومات (بانر أفقي) -->
    <section class="promo-banner">
        <p>خصم 20% على جميع العطور الرجالية! استخدم الكود: **ILO20**</p>
        <a href="products.php?category=رجالي" class="btn-primary">تسوق الآن</a>
    </section>
</main>

<?php
// تضمين ملف التذييل (Footer)
include __DIR__ . '/../includes/footer.php';
?>
