<?php
include 'db_connect.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM content WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['name']; ?> - تفاصيل المعلم</title>
    <!-- استدعاء ملف الـ CSS الموحد -->
    <link rel="stylesheet" href="style.css">
    <style>
        /* تعديل خاص لصفحة التفاصيل لتسمح بالتمرير الطويل */
        body { display: block; height: auto; padding: 20px; }
    </style>
</head>
<body>

    <div class="details-container">
        <div class="details-header">
            <span class="category-badge"><?php echo $data['category']; ?></span>
            <h1><?php echo $data['name']; ?></h1>
        </div>

        <div class="description-text">
            <?php echo $data['description']; ?>
        </div>

        <a href="index.php" class="back-btn">← العودة للرئيسية</a>
    </div>

    <footer style="text-align: center; margin-top: 50px; color: #888;">
        <p>&copy; 2026 مشروع اكتشف السعودية</p>
    </footer>

</body>
</html>