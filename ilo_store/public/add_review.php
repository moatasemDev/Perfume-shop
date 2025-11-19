<?php
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'] ?? 0;
    $rating = $_POST['rating'] ?? 0;
    $comment = $_POST['comment'] ?? '';
    $user_id = $_SESSION["id"] ?? null;

    if ($user_id && $product_id > 0 && $rating >= 1 && $rating <= 5 && !empty($comment)) {
        if (add_review($product_id, $user_id, $rating, $comment)) {
            // تم إضافة التقييم بنجاح
            header("location: product.php?id=" . $product_id . "&review_success=1");
            exit;
        } else {
            // فشل إضافة التقييم
            header("location: product.php?id=" . $product_id . "&review_error=1");
            exit;
        }
    } else {
        // بيانات غير صالحة أو المستخدم غير مسجل الدخول
        header("location: product.php?id=" . $product_id . "&review_error=2");
        exit;
    }
}

header("location: index.php");
exit;
?>
