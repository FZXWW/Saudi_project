<?php
session_start();
include 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // استعلام للتحقق من المشرف
    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // التحقق من كلمة المرور (مشفره)
        if ($password == $user['password']) {            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "كلمة المرور غير صحيحة!";
        }
    } else {
        $error = "اسم المستخدم غير موجود!";
    }
}
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول المشرف</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-card">
        <h2>تسجيل دخول المشرف</h2>

        <!-- عرض رسالة الخطأ فقط إذا وجد خطأ -->
        <?php if (!empty($error)): ?>
            <div class="error-msg">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="input-group">
                <input type="text" name="username" placeholder="اسم المستخدم" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="كلمة المرور" required>
            </div>
            <button type="submit">دخول</button>
        </form>
    </div>

</body>
</html>