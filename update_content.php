<?php
session_start();
include 'db_connect.php';

// حماية الصفحة
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$id = $_GET['id']; // جلب رقم السجل المراد تعديله من الرابط

// 1. جلب البيانات الحالية للسجل لعرضها في الحقول
$stmt = $conn->prepare("SELECT * FROM content WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// 2. معالجة التحديث عند الضغط على زر الحفظ
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    
    $update_stmt = $conn->prepare("UPDATE content SET name = ?, category = ?, description = ? WHERE id = ?");
    $update_stmt->bind_param("sssi", $name, $category, $description, $id);
    
    if ($update_stmt->execute()) {
        header("Location: dashboard.php?msg=updated");
        exit();
    } else {
        $message = "حدث خطأ أثناء التحديث!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل بيانات المنطقة</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <h2>تعديل بيانات: <?php echo $data['name']; ?></h2>
    
    <?php if($message): ?>
        <p style="color: var(--error-color); text-align: center;"><?php echo $message; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>اسم المنطقة:</label>
            <input type="text" name="name" value="<?php echo $data['name']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>التصنيف الإداري:</label>
            <select name="category" required>
                <option value="المنطقة الوسطى" <?php if($data['category'] == 'المنطقة الوسطى') echo 'selected'; ?>>المنطقة الوسطى</option>
                <option value="المنطقة الغربية" <?php if($data['category'] == 'المنطقة الغربية') echo 'selected'; ?>>المنطقة الغربية</option>
                <option value="المنطقة الشرقية" <?php if($data['category'] == 'المنطقة الشرقية') echo 'selected'; ?>>المنطقة الشرقية</option>
                <option value="المنطقة الشمالية" <?php if($data['category'] == 'المنطقة الشمالية') echo 'selected'; ?>>المنطقة الشمالية</option>
                <option value="المنطقة الجنوبية" <?php if($data['category'] == 'المنطقة الجنوبية') echo 'selected'; ?>>المنطقة الجنوبية</option>
            </select>
        </div>

        <div class="form-group">
            <label>الوصف:</label>
            <textarea name="description" required><?php echo $data['description']; ?></textarea>
        </div>
        
        <button type="submit">تحديث البيانات</button>
    </form>
    
    <a href="dashboard.php" class="back-link">← إلغاء والعودة للوحة التحكم</a>
</div>

</body>
</html>