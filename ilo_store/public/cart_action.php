<?php
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    $product_id = $_POST['product_id'] ?? 0;
    $quantity = $_POST['quantity'] ?? 1;

    switch ($action) {
        case 'add':
            add_to_cart($product_id, $quantity);
            break;
        case 'update':
            update_cart_item($product_id, $quantity);
            break;
        case 'remove':
            remove_from_cart($product_id);
            break;
        default:
            // لا شيء
            break;
    }
    
    // إرجاع محتوى السلة المحدث (اختياري، يمكن إرجاع JSON)
    // لتبسيط المشروع، سنقوم بإعادة التوجيه إلى صفحة السلة
    header("location: cart.php");
    exit;
}

// إذا كان الطلب GET أو غير صالح، قم بإعادة التوجيه إلى الصفحة الرئيسية
header("location: index.php");
exit;
?>
