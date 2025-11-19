<?php
require_once __DIR__ . '/../includes/functions.php';

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if (empty($username)) {
        $username_err = "الرجاء إدخال اسم المستخدم.";
    }
    if (empty($password)) {
        $password_err = "الرجاء إدخال كلمة المرور.";
    }

    if (empty($username_err) && empty($password_err)) {
        if (login_user($username, $password)) {
            header("location: index.php");
            exit;
        } else {
            $login_err = "اسم المستخدم أو كلمة المرور غير صحيحة.";
        }
    }
}

// تضمين ملف الرأس (Header)
include __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>تسجيل الدخول</h1>
    
    <?php if (!empty($login_err)): ?>
        <div class="alert alert-danger"><?= $login_err ?></div>
    <?php endif; ?>

    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="auth-form">
        <div class="form-group">
            <label for="username">اسم المستخدم:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>
            <span class="error-message"><?= $username_err ?></span>
        </div>
        
        <div class="form-group">
            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required>
            <span class="error-message"><?= $password_err ?></span>
        </div>
        
        <button type="submit" class="btn-primary">دخول</button>
        <p>ليس لديك حساب؟ <a href="register.php">سجل الآن</a>.</p>
    </form>
</main>

<?php
// تضمين ملف التذييل (Footer)
include __DIR__ . '/../includes/footer.php';
?>
