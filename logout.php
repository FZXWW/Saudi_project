<?php
session_start();
session_destroy(); // تدمير جميع بيانات الجلسة
header("Location: login.php"); // العودة لصفحة الدخول
exit();
?>