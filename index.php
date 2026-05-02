<?php
include 'db_connect.php';

// جلب البيانات لعرضها للزوار
$query = "SELECT * FROM content ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اكتشف السعودية - بوابة السياحة</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* تعديل بسيط ليتناسب الـ flex مع المحتوى الطويل في الصفحة الرئيسية */
        body { display: block; height: auto; } 
    </style>
</head>
<body>

    <header class="hero-section">
        <h1>اكتشف سحر السعودية 🇸🇦</h1>
        <p>استكشف أجمل المعالم السياحية والمناطق التاريخية في المملكة</p>
    </header>

    <main class="content-grid">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="public-card">
                <div class="public-card-body">
                    <span class="category-badge"><?php echo $row['category']; ?></span>
                    <h3><?php echo $row['name']; ?></h3>
                    <p><?php echo mb_strimwidth($row['description'], 0, 120, "..."); ?></p>
                </div>
                <a href="details.php?id=<?php echo $row['id']; ?>" class="view-btn">استكشف المزيد</a>
            </div>
        <?php endwhile; ?>

        <?php if ($result->num_rows == 0): ?>
            <p style="text-align:center; color:white; grid-column: 1/-1;">لا يوجد محتوى متاح حالياً. سيتم إضافة المعالم قريباً!</p>
        <?php endif; ?>
    </main>

    <footer style="text-align: center; padding: 20px; color: #888;">
        <p>&copy; 2026 مشروع اكتشف السعودية - برمجة محمد القرشي</p>
        <a href="login.php" style="color: #555; text-decoration: none; font-size: 0.8rem;">دخول المشرف</a>
    </footer>

</body>
</html>