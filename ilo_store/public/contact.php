<?php
require_once __DIR__ . '/../includes/functions.php';

$message_sent = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // لتبسيط المشروع، لن يتم إرسال بريد إلكتروني فعلياً، بل سيتم محاكاة الإرسال
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // هنا يمكن إضافة كود إرسال البريد الإلكتروني (مثل دالة mail() في PHP)
        // أو تخزين الرسالة في قاعدة البيانات
        $message_sent = true;
    }
}

include __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>تواصل معنا</h1>
    
    <section class="contact-info">
        <p>نحن هنا للإجابة على جميع استفساراتكم. لا تترددوا في التواصل معنا عبر الطرق التالية:</p>
        <ul>
            <li><strong>البريد الإلكتروني:</strong> info@ilovan.com</li>
            <li><strong>الهاتف:</strong> 967.....</li>
            <li><strong>العنوان:</strong> صنعاء - الجمهوريه اليمنيه</li>
        </ul>
        <div class="social-links">
            <a href="#">Facebook</a> | 
            <a href="#">Instagram</a> | 
            <a href="#">Twitter</a>
        </div>
    </section>

    <section class="contact-form-section">
        <h2>أرسل لنا رسالة</h2>
        <?php if ($message_sent): ?>
            <div class="alert alert-success">شكراً لك! تم استلام رسالتك وسنقوم بالرد عليك في أقرب وقت ممكن.</div>
        <?php else: ?>
            <form action="contact.php" method="POST" class="contact-form">
                <div class="form-group">
                    <label for="name">الاسم:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">البريد الإلكتروني:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="subject">الموضوع:</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message">الرسالة:</label>
                    <textarea id="message" name="message" rows="6" required></textarea>
                </div>
                <button type="submit" class="btn-primary">إرسال الرسالة</button>
            </form>
        <?php endif; ?>
    </section>
</main>

<?php
include __DIR__ . '/../includes/footer.php';
?>
