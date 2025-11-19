<?php
require_once __DIR__ . '/../includes/functions.php';

$cart_items = get_cart_items();
$cart_total = get_cart_total();

// تضمين ملف الرأس (Header)
include __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>سلة التسوق</h1>
    
    <?php if (count($cart_items) > 0): ?>
        <section class="cart-items">
            <table>
                <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>الإجمالي</th>
                        <th>إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="cart-item-img">
                                <?= htmlspecialchars($item['name']) ?>
                            </td>
                            <td><?= number_format($item['price'], 2) ?> ر.س</td>
                            <td>
                                <form action="cart_action.php" method="POST" class="update-cart-form">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td><?= number_format($item['price'] * $item['quantity'], 2) ?> ر.س</td>
                            <td>
                                <form action="cart_action.php" method="POST">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section class="cart-summary">
            <h2>ملخص الطلب</h2>
            <p>المجموع الفرعي: <span><?= number_format($cart_total, 2) ?> ر.س</span></p>
            <p>الشحن: <span>مجاني</span></p>
            <h3>الإجمالي: <span><?= number_format($cart_total, 2) ?> ر.س</span></h3>
            <a href="checkout.php" class="btn-primary checkout-btn">إتمام الشراء</a>
        </section>
    <?php else: ?>
        <p>سلة التسوق فارغة. <a href="products.php">ابدأ التسوق الآن!</a></p>
    <?php endif; ?>
</main>

<?php
// تضمين ملف التذييل (Footer)
include __DIR__ . '/../includes/footer.php';
?>
