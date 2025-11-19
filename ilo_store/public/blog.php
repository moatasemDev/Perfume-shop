<?php
require_once __DIR__ . '/../includes/functions.php';

$articles = get_all_articles();

// تضمين ملف الرأس (Header)
include __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>مدونة إيلوفان</h1>
    
    <section class="article-list">
        <div class="article-grid">
            <?php if (count($articles) > 0): ?>
                <?php foreach ($articles as $article): ?>
                    <div class="article-card">
                        <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                        <h3><?= htmlspecialchars($article['title']) ?></h3>
                        <p class="category"><?= htmlspecialchars($article['category']) ?></p>
                        <a href="article.php?id=<?= $article['id'] ?>" class="btn-link">اقرأ المزيد</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>لا توجد مقالات متاحة حالياً.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
//(Footer)
include __DIR__ . '/../includes/footer.php';
?>
