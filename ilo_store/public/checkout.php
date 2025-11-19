<?php
require_once __DIR__ . '/../includes/functions.php';

$cart_items = get_cart_items();
$cart_total = get_cart_total();

if (count($cart_items) == 0) {
    header("location: cart.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shipping_address = trim($_POST['shipping_address'] ?? '');
    $payment_method = $_POST['payment_method'] ?? '';
    $user_id = $_SESSION["id"] ?? null; // يجب أن يكون المستخدم مسجلاً للدفع

    if (empty($shipping_address) || empty($payment_method)) {
        $error = "يرجى ملء جميع الحقول المطلوبة.";
    } else {
        // سنفترض أن المستخدم مسجل الدخول (user_id = 1) إذا لم يكن مسجلاً
        //جب التحقق من تسجيل الدخول
        if (!$user_id) {
            // إنشاء مستخدم وهمي أو مطالبة المستخدم بالتسجيل/الدخول
            // لغرض العرض،  ID=1
            $user_id = 1; 
        }

        $order_id = create_order($user_id, $cart_total, $shipping_address, $payment_method, $cart_items);
        
        if ($order_id) {
            $success = "تم إتمام طلبك بنجاح! رقم الطلب هو: " . $order_id;
            // إعادة التوجيه بعد نجاح الطلب
            header("refresh:5;url=index.php");
        } else {
            $error = "حدث خطأ أثناء إتمام الطلب. يرجى المحاولة مرة أخرى.";
        }
    }
}

// تضمين ملف الرأس (Header)
include __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>إتمام الدفع</h1>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
        <p>سيتم تحويلك إلى الصفحة الرئيسية خلال 5 ثوانٍ.</p>
    <?php else: ?>
        <div class="checkout-layout">
            <section class="shipping-payment-form">
                <h2>معلومات الشحن والدفع</h2>
                <form action="checkout.php" method="POST">
                    <div class="form-group">
                        <label for="shipping_address">عنوان الشحن:</label>
                        <textarea id="shipping_address" name="shipping_address" rows="4" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>طريقة الدفع:</label>
                        <div class="payment-options">
                            <input type="radio" id="card" name="payment_method" value="بطاقة" required>
                            <label for="card">بطاقة ائتمانية</label><br>
                            
                            <input type="radio" id="paypal" name="payment_method" value="باي بال">
                            <label for="paypal">باي بال</label><br>
                            
                            <input type="radio" id="cod" name="payment_method" value="دفع عند الاستلام">
                            <label for="cod">الدفع عند الاستلام</label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-primary">تأكيد الطلب والدفع</button>
                </form>
            </section>
            
            <section class="order-summary">
                <h2>ملخص الطلب</h2>
                <?php foreach ($cart_items as $item): ?>
                    <div class="summary-item">
                        <p><?= htmlspecialchars($item['name']) ?> (x<?= $item['quantity'] ?>)</p>
                        <p><?= number_format($item['price'] * $item['quantity'], 2) ?> ر.س</p>
                    </div>
                <?php endforeach; ?>
                <hr>
                <p>المجموع الفرعي: <span><?= number_format($cart_total, 2) ?> ر.س</span></p>
                <p>الشحن: <span>مجاني</span></p>
                <h3>الإجمالي: <span><?= number_format($cart_total, 2) ?> ر.س</span></h3>
            </section>
        </div>
    <?php endif; ?>
</main>

<?php
// تضمين ملف التذييل (Footer)
include __DIR__ . '/../includes/footer.php';
?>
