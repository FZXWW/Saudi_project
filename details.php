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
    <title><?php echo $data['name']; ?> - التفاصيل</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- شريط التنقل العلوي -->
    <nav class="navbar">
        <div class="logo">اكتشف السعودية</div>
        <div class="nav-links">
            <a href="index.php">الرئيسية</a>
            <a href="index.php#explore">معرض المناطق</a>
            <a href="login.php">دخول المشرف</a>
        </div>
    </nav>

    <div class="container" style="max-width: 1000px; margin: 20px auto; background: transparent; box-shadow: none;">
        
        <!-- الصورة البارزة (الرئيسية) -->
        <img src="images/<?php echo $data['image_url']; ?>" class="hero-image-large" alt="<?php echo $data['name']; ?>">

        <div class="details-content">
            <h1><?php echo $data['name']; ?></h1>
            
            <div class="quick-info-box">
                <h4>📍 نبذة سريعة</h4>
                <p><strong>المنطقة:</strong> <?php echo $data['category']; ?></p>
                <p><strong>المميزات:</strong> <?php echo !empty($data['features']) ? $data['features'] : 'لا يوجد مميزات مضافة'; ?></p>
            </div>

            <h3>📝 الوصف والأنشطة</h3>
            <p><?php echo $data['description']; ?></p>

            <!-- معرض الصور - التحقق من وجود كل صورة قبل عرضها -->
            <h3>🖼️ معرض الصور</h3>
            <div class="photo-gallery">
                <?php if(!empty($data['gallery1'])): ?>
                    <div class="gallery-item"><img src="images/<?php echo $data['gallery1']; ?>"></div>
                <?php endif; ?>

                <?php if(!empty($data['gallery2'])): ?>
                    <div class="gallery-item"><img src="images/<?php echo $data['gallery2']; ?>"></div>
                <?php endif; ?>

                <?php if(!empty($data['gallery3'])): ?>
                    <div class="gallery-item"><img src="images/<?php echo $data['gallery3']; ?>"></div>
                <?php endif; ?>
            </div>

            <a href="index.php" class="back-link" style="color: var(--primary-color); font-weight: bold; margin-top: 40px; display: inline-block;">← العودة لمعرض المناطق</a>
        </div>
    </div>

    <footer style="text-align: center; padding: 40px; color: #888;">
        © 2026 اكتشف السعودية — جامعة الملك سعود
    </footer>

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