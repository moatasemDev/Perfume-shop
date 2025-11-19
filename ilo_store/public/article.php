<?php
require_once __DIR__ . '/../includes/functions.php';

$article_id = $_GET['id'] ?? 0;
$article = get_article_by_id($article_id);

if (!$article) {
    header("location: blog.php");
    exit;
}

// تضمين ملف الرأس (Header)
include __DIR__ . '/../includes/header.php';
?>

<main>
    <article class="article-content">
        <h1><?= htmlspecialchars($article['title']) ?></h1>
        <p class="meta">
            <span>الكاتب: <?= htmlspecialchars($article['author']) ?></span> | 
            <span>التصنيف: <?= htmlspecialchars($article['category']) ?></span> | 
            <span>التاريخ: <?= date('Y-m-d', strtotime($article['created_at'])) ?></span>
        </p>
        <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="article-image">
        <div class="article-body">
            <?= nl2br(htmlspecialchars($article['content'])) ?>
        </div>
    </article>
</main>

<?php
// تضمين ملف التذييل (Footer)
include __DIR__ . '/../includes/footer.php';
?>
