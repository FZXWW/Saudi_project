<?php
session_start();
include 'db_connect.php';

// حماية الصفحة
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// حل مشكلة المتغير غير المعرف - تعريف المتغير بقيمة فارغة في البداية
$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $features = $_POST['features'];
    $activities = $_POST['activities'];
    $landmarks = $_POST['landmarks'];

    // التعامل مع الصور
    $main_image = $_FILES['image_url']['name'];
    $gallery1 = $_FILES['gallery1']['name'];
    $gallery2 = $_FILES['gallery2']['name'];
    $gallery3 = $_FILES['gallery3']['name'];

    // مسارات الرفع
    move_uploaded_file($_FILES['image_url']['tmp_name'], "images/" . $main_image);
    move_uploaded_file($_FILES['gallery1']['tmp_name'], "images/" . $gallery1);
    move_uploaded_file($_FILES['gallery2']['tmp_name'], "images/" . $gallery2);
    move_uploaded_file($_FILES['gallery3']['tmp_name'], "images/" . $gallery3);

    $stmt = $conn->prepare("INSERT INTO content (name, category, description, image_url, features, activities, landmarks, gallery1, gallery2, gallery3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $name, $category, $description, $main_image, $features, $activities, $landmarks, $gallery1, $gallery2, $gallery3);

    if ($stmt->execute()) {
        $message = "✅ تم إضافة المكان بنجاح!";
    } else {
        $message = "❌ حدث خطأ أثناء الإضافة.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة مكان جديد - لوحة التحكم</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* ستايل مخصص لتقسيم الفورم بشكل عصري */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .full-row { grid-column: span 2; }
        
        .section-divider {
            grid-column: span 2;
            background: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            margin: 20px 0 10px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">اكتشف السعودية</div>
        <div class="nav-links">
            <a href="dashboard.php">لوحة التحكم</a>
            <a href="logout.php" style="color: var(--error-color);">تسجيل الخروج</a>
        </div>
    </nav>

    <div class="form-container" style="max-width: 900px; margin-top: 40px;">
        <h2>✨ إضافة وجهة سعودية جديدة</h2>

        <?php if ($message): ?>
            <div style="padding: 15px; margin-bottom: 20px; border-radius: 8px; text-align: center; background: rgba(0, 94, 59, 0.1); border: 1px solid var(--primary-color);">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="add_content.php" method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                
                <div class="section-divider">📍 المعلومات الأساسية</div>

                <div class="form-group">
                    <label>اسم المكان:</label>
                    <input type="text" name="name" placeholder="مثال: مدينة العلا" required>
                </div>

                <div class="form-group">
                    <label>الموقع (المنطقة):</label>
                    <select name="category" required>
                        <option value="">اختر المنطقة...</option>
                        <option value="المنطقة الوسطى">المنطقة الوسطى</option>
                        <option value="المنطقة الغربية">المنطقة الغربية</option>
                        <option value="المنطقة الشرقية">المنطقة الشرقية</option>
                        <option value="المنطقة الشمالية">المنطقة الشمالية</option>
                        <option value="المنطقة الجنوبية">المنطقة الجنوبية</option>
                    </select>
                </div>

                <div class="section-divider">✨ التفاصيل الإضافية</div>

                <div class="form-group">
                    <label>المميزات:</label>
                    <input type="text" name="features" placeholder="مثال: مواقع أثرية، طبيعة خلابة">
                </div>

                <div class="form-group">
                    <label>الأنشطة المتاحة:</label>
                    <input type="text" name="activities" placeholder="مثال: رحلات جبلية، تخييم">
                </div>

                <div class="form-group full-row">
                    <label>المعالم البارزة (افصل بينها بفاصلة):</label>
                    <input type="text" name="landmarks" placeholder="مثال: مدائن صالح، جبل الفيل">
                </div>

                <div class="form-group full-row">
                    <label>وصف تفصيلي عن المكان:</label>
                    <textarea name="description" rows="5" placeholder="اكتب وصفاً جذاباً وتاريخياً للمكان..." required></textarea>
                </div>

                <div class="section-divider">🖼️ معرض الصور</div>

                <div class="form-group">
                    <label>الصورة الرئيسية للمكان:</label>
                    <input type="file" name="image_url" required>
                </div>

                <div class="form-group">
                    <label>صورة المعرض الأولى:</label>
                    <input type="file" name="gallery1" required>
                </div>

                <div class="form-group">
                    <label>صورة المعرض الثانية (اختياري):</label>
                    <input type="file" name="gallery2">
                </div>

                <div class="form-group">
                    <label>صورة المعرض الثالثة (اختياري):</label>
                    <input type="file" name="gallery3">
                </div>

            </div>

            <button type="submit" class="btn-add" style="width: 100%; margin-top: 30px; padding: 18px; font-size: 1.1rem;">
                🚀 اعتماد وإضافة المكان للموقع
            </button>
        </form>

        <div style="text-align: center; margin-top: 25px;">
            <a href="dashboard.php" class="back-link">← العودة للوحة التحكم</a>
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