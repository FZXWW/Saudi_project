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
        // التحقق من كلمة المرور
        if ($password == $user['password']) {
            $_SESSION['admin_id'] = $user['id'];
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
    <title>تسجيل دخول المشرف - اكتشف السعودية</title>
    <!-- تأكد أن ملف style.css يحتوي على الكود الأخير الذي أرسلته لك -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-body"> <!-- الكلاس الضروري لتوسيط البطاقة والخلفية -->

    <!-- إضافة الناف بار هنا -->
    <nav class="navbar" style="position: absolute; top: 0; width: 100%;">
        <div class="logo">اكتشف السعودية</div>
        <div class="nav-links">
            <a href="index.php">الرئيسية</a>
            <a href="index.php#explore">معرض المناطق</a>
        </div>
         <div class="nav-links">
            <span id="theme-toggle" style="cursor: pointer; font-size: 1.2rem; margin-right: 15px; user-select: none;">
                🌙
            </span>
        </div>
    </nav>

    <div class="login-card">
        <div style="font-size: 3.5rem; margin-bottom: 15px;">🛡️</div>
        <h2>تسجيل دخول المشرف</h2>

        <!-- عرض رسالة الخطأ بتنسيق عصري -->
        <?php if (!empty($error)): ?>
            <div class="error-msg" style="background: rgba(231, 76, 60, 0.1); border: 1px solid var(--error-color); border-radius: 8px; padding: 10px; margin-bottom: 20px;">
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
            <button type="submit">دخول النظام</button>
        </form>

        <div style="margin-top: 30px;">
            <a href="index.php" class="back-link">← العودة للموقع الرئيسي</a>
        </div>
    </div>

    <script>
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;

    // التحقق من الوضع المحفوظ مسبقاً
    if (localStorage.getItem('theme') === 'light') {
        body.classList.add('light-mode');
        themeToggle.innerText = '☀️';
    }

    themeToggle.addEventListener('click', () => {
        body.classList.toggle('light-mode');
        
        // حفظ الخيار وتغيير الأيقونة
        if (body.classList.contains('light-mode')) {
            localStorage.setItem('theme', 'light');
            themeToggle.innerText = '☀️';
        } else {
            localStorage.setItem('theme', 'dark');
            themeToggle.innerText = '🌙';
        }
    });
</script>
</body>
</html>