<?php
$host = "localhost";
$user = "root";
$pass = ""; // في واجهة Wamp الافتراضية يكون الرقم السري فارغاً
$db_name = "discovery_saudi";

// إنشاء الاتصال
$conn = new mysqli($host, $user, $pass, $db_name);

// التحقق من أن الاتصال يعمل
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// ضبط الترميز ليدعم النصوص العربية بشكل صحيح
$conn->set_charset("utf8mb4");
?>