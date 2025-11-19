<?php
// إعدادات الاتصال بقاعدة البيانات
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // اسم المستخدم الافتراضي في بيئة Sandbox
define('DB_PASSWORD', ''); // كلمة المرور الافتراضية في بيئة Sandbox
define('DB_NAME', 'ilo_store');

// محاولة الاتصال بقاعدة البيانات MySQL
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// التحقق من الاتصال
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
