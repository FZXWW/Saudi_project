<?php
$host = "sql211.infinityfree.com";
$user = "if0_41837706";
$pass = "Drfofo11"; // في واجهة Wamp الافتراضية يكون الرقم السري فارغاً
$db_name = "if0_41837706_saudiLandMarkProject";

// إنشاء الاتصال
$conn = new mysqli($host, $user, $pass, $db_name);

// التحقق من أن الاتصال يعمل
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// ضبط الترميز ليدعم النصوص العربية بشكل صحيح
$conn->set_charset("utf8mb4");
?>