<?php
require_once __DIR__ . '/../includes/functions.php';
logout_user();
header("location: index.php");
exit;
?>
