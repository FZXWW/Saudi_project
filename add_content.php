<?php
session_start();
include 'db_connect.php';

// حماية الصفحة
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    
    $stmt = $conn->prepare("INSERT INTO content (name, category, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $category, $description);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=added");
        exit();
    } else {
        $message = "حدث خطأ أثناء الإضافة!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منطقة جديدة</title>
    <!-- ربط ملف الـ CSS الموحد -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <h2>إضافة منطقة/معلم جديد</h2>
    
    <?php if($message): ?>
        <p style="color: var(--error-color); text-align: center;"><?php echo $message; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <input type="text" name="name" placeholder="اسم المنطقة (مثلاً: العلا)" required>
        </div>
        
        <div class="form-group">
            <select name="category" required>
                <option value="" disabled selected>اختر المنطقة الإدارية</option>
                <option value="المنطقة الوسطى">المنطقة الوسطى</option>
                <option value="المنطقة الغربية">المنطقة الغربية</option>
                <option value="المنطقة الشرقية">المنطقة الشرقية</option>
                <option value="المنطقة الشمالية">المنطقة الشمالية</option>
                <option value="المنطقة الجنوبية">المنطقة الجنوبية</option>
            </select>
        </div>

        <div class="form-group">
            <textarea name="description" placeholder="وصف المنطقة ومعالمها الشهيرة..." required></textarea>
        </div>
        
        <button type="submit">حفظ البيانات</button>
    </form>
    
    <a href="dashboard.php" class="back-link">← العودة للوحة التحكم</a>
</div>

</body>
</html>