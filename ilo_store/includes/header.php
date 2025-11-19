<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$cart_count = count($_SESSION['cart'] ?? []);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إيلوفان (Ilovan) - متجر العطور الفاخرة</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="top-bar">
            <div class="logo">
                <a href="index.php">إيلوفان (Ilovan)</a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">الرئيسية</a></li>
                    <li><a href="products.php">المنتجات</a></li>
                    <li><a href="blog.php">المقالات</a></li>
                    <li><a href="about.php">من نحن</a></li>
                    <li><a href="contact.php">تواصل معنا</a></li>
                </ul>
            </nav>
            <div class="user-actions">
                <a href="cart.php" class="cart-icon">
                    🛒 <span class="cart-count"><?= $cart_count ?></span>
                </a>
                <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <a href="profile.php" class="user-icon">👤 <?= htmlspecialchars($_SESSION["username"]) ?></a>
                    <a href="logout.php" class="btn-small">خروج</a>
                <?php else: ?>
                    <a href="login.php" class="btn-small">دخول / تسجيل</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="search-bar">
            <form action="search.php" method="GET">
                <input type="text" name="q" placeholder="ابحث عن عطر أو مقال..." required>
                <button type="submit">🔍</button>
            </form>
        </div>
    </header>
    <div class="container">
