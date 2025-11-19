<?php
require_once __DIR__ . '/../includes/functions.php';

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";
$success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // التحقق من اسم المستخدم
    $username = trim($_POST["username"] ?? '');
    if (empty($username)) {
        $username_err = "الرجاء إدخال اسم المستخدم.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $username_err = "اسم المستخدم يمكن أن يحتوي على أحرف إنجليزية وأرقام وشرطة سفلية فقط.";
    } else {
        // التحقق من توفر اسم المستخدم (لتبسيط المشروع، لن نتحقق من قاعدة البيانات هنا)
    }

    // التحقق من البريد الإلكتروني
    $email = trim($_POST["email"] ?? '');
    if (empty($email)) {
        $email_err = "الرجاء إدخال البريد الإلكتروني.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "صيغة البريد الإلكتروني غير صحيحة.";
    }

    // التحقق من كلمة المرور
    $password = trim($_POST["password"] ?? '');
    if (empty($password)) {
        $password_err = "الرجاء إدخال كلمة المرور.";
    } elseif (strlen($password) < 6) {
        $password_err = "يجب أن تكون كلمة المرور 6 أحرف على الأقل.";
    }

    // التحقق من تأكيد كلمة المرور
    $confirm_password = trim($_POST["confirm_password"] ?? '');
    if (empty($confirm_password)) {
        $confirm_password_err = "الرجاء تأكيد كلمة المرور.";
    } elseif ($password != $confirm_password) {
        $confirm_password_err = "كلمة المرور وتأكيدها غير متطابقين.";
    }

    // إذا لم تكن هناك أخطاء، قم بالتسجيل
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        if (register_user($username, $email, $password)) {
            $success_msg = "تم تسجيل حسابك بنجاح. يمكنك الآن تسجيل الدخول.";
            // مسح الحقول بعد التسجيل الناجح
            $username = $email = $password = $confirm_password = "";
        } else {
            $username_err = "حدث خطأ ما. قد يكون اسم المستخدم أو البريد الإلكتروني مستخدماً بالفعل.";
        }
    }
}

// تضمين ملف الرأس (Header)
include __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>تسجيل حساب جديد</h1>
    
    <?php if (!empty($success_msg)): ?>
        <div class="alert alert-success"><?= $success_msg ?></div>
    <?php endif; ?>

    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="auth-form">
        <div class="form-group">
            <label for="username">اسم المستخدم:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>
            <span class="error-message"><?= $username_err ?></span>
        </div>
        
        <div class="form-group">
            <label for="email">البريد الإلكتروني:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            <span class="error-message"><?= $email_err ?></span>
        </div>
        
        <div class="form-group">
            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required>
            <span class="error-message"><?= $password_err ?></span>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">تأكيد كلمة المرور:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <span class="error-message"><?= $confirm_password_err ?></span>
        </div>
        
        <button type="submit" class="btn-primary">تسجيل</button>
        <p>لديك حساب بالفعل؟ <a href="login.php">سجل الدخول</a>.</p>
    </form>
</main>

<?php
// تضمين ملف التذييل (Footer)
include __DIR__ . '/../includes/footer.php';
?>
