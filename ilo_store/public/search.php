<?php
require_once __DIR__ . '/../includes/functions.php';

$query = $_GET['q'] ?? '';
$results = [];

if (!empty($query)) {
    $results = search_all($query);
}

// تضمين ملف الرأس (Header)
include __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>نتائج البحث عن: "<?= htmlspecialchars($query) ?>"</h1>
    
    <?php if (empty($query)): ?>
        <p>الرجاء إدخال كلمة للبحث.</p>
    <?php elseif (count($results) > 0): ?>
        <section class="search-results">
            <?php foreach ($results as $result): ?>
                <div class="result-item">
                    <?php if ($result['type'] == 'product'): ?>
                        <h3><a href="product.php?id=<?= $result['id'] ?>"><?= htmlspecialchars($result['name']) ?></a></h3>
                        <p>النوع: منتج</p>
                    <?php elseif ($result['type'] == 'article'): ?>
                        <h3><a href="article.php?id=<?= $result['id'] ?>"><?= htmlspecialchars($result['name']) ?></a></h3>
                        <p>النوع: مقال</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
    <?php else: ?>
        <p>لم يتم العثور على نتائج مطابقة لبحثك.</p>
    <?php endif; ?>
</main>

<?php
// تضمين ملف التذييل (Footer)
include __DIR__ . '/../includes/footer.php';
?>
