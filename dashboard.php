<?php
session_start();
include 'db_connect.php';

// حماية الصفحة
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// جلب البيانات
$query = "SELECT * FROM content";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - إدارة المحتوى</title>
    <!-- استدعاء ملف الـ CSS الخارجي -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <a href="logout.php" class="btn-logout">تسجيل الخروج</a>
    <h2>لوحة تحكم المشرف - إدارة المحتوى</h2>
    <p>مرحباً بك يا <strong><?php echo $_SESSION['username']; ?></strong> 👋</p>
    
    <div style="overflow: hidden; margin-bottom: 20px;">
        <a href="add_content.php" class="btn-add">إضافة محتوى جديد +</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>المنطقة/المكان</th>
                <th>التصنيف</th>
                <th>الوصف</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo mb_strimwidth($row['description'], 0, 50, "..."); ?></td>
                <td class="action-links">
                    <a href="update_content.php?id=<?php echo $row['id']; ?>" class="btn-update">تعديل</a> | 
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذا السجل؟')">حذف</a>
                </td>
            </tr>
            <?php endwhile; ?>
            
            <?php if ($result->num_rows == 0): ?>
                <tr><td colspan="5">لا يوجد محتوى حالياً. ابدأ بإضافة أول منطقة!</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>