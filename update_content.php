<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$id = $_GET['id'];

// جلب البيانات
$stmt = $conn->prepare("SELECT * FROM content WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// معالجة التحديث
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $features = $_POST['features'];
    $activities = $_POST['activities'];
    $landmarks = $_POST['landmarks'];

    $image_url = !empty($_FILES['image_url']['name']) ? $_FILES['image_url']['name'] : $data['image_url'];
    $gallery1 = !empty($_FILES['gallery1']['name']) ? $_FILES['gallery1']['name'] : $data['gallery1'];
    $gallery2 = !empty($_FILES['gallery2']['name']) ? $_FILES['gallery2']['name'] : $data['gallery2'];
    $gallery3 = !empty($_FILES['gallery3']['name']) ? $_FILES['gallery3']['name'] : $data['gallery3'];

    if(!empty($_FILES['image_url']['name'])) move_uploaded_file($_FILES['image_url']['tmp_name'], "images/".$image_url);
    if(!empty($_FILES['gallery1']['name'])) move_uploaded_file($_FILES['gallery1']['tmp_name'], "images/".$gallery1);
    if(!empty($_FILES['gallery2']['name'])) move_uploaded_file($_FILES['gallery2']['tmp_name'], "images/".$gallery2);
    if(!empty($_FILES['gallery3']['name'])) move_uploaded_file($_FILES['gallery3']['tmp_name'], "images/".$gallery3);

    $sql = "UPDATE content SET name=?, category=?, description=?, features=?, activities=?, landmarks=?, image_url=?, gallery1=?, gallery2=?, gallery3=? WHERE id=?";
    $update_stmt = $conn->prepare($sql);
    $update_stmt->bind_param("ssssssssssi", $name, $category, $description, $features, $activities, $landmarks, $image_url, $gallery1, $gallery2, $gallery3, $id);
    
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
    <title>تعديل احترافي: <?php echo $data['name']; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* ستايل إضافي لصفحة التعديل لجعلها أكثر عصرية */
        .form-container {
            border: 1px solid rgba(0, 94, 59, 0.2);
            position: relative;
            overflow: hidden;
        }
        .form-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 5px;
            background: linear-gradient(to right, #005e3b, #2ecc71);
        }
        .grid-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .full-width { grid-column: span 2; }
        
        .image-preview-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            background: #252525;
            padding: 20px;
            border-radius: 12px;
            margin-top: 10px;
        }
        .image-status {
            font-size: 0.8rem;
            color: var(--primary-color);
            margin-bottom: 5px;
            display: block;
        }
        .section-title {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin: 30px 0 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="logo">⚙️ لوحة التحكم</div>
    <div class="nav-links">
        <a href="dashboard.php" class="back-link">العودة للرئيسية</a>
    </div>
    <div class="nav-links">
            <span id="theme-toggle" style="cursor: pointer; font-size: 1.2rem; margin-right: 15px; user-select: none;">
                🌙
            </span>
    </div>
</nav>

<div class="form-container" style="max-width: 900px; margin-top: 40px;">
    <h2>تعديل البيانات: <span style="color: #fff;"><?php echo $data['name']; ?></span></h2>
    
    <form method="POST" enctype="multipart/form-data">
        
        <div class="section-title">📍 المعلومات الأساسية</div>
        <div class="grid-inputs">
            <div class="form-group">
                <label>اسم المكان</label>
                <input type="text" name="name" value="<?php echo $data['name']; ?>" placeholder="أدخل اسم المعلم..." required>
            </div>

            <div class="form-group">
                <label>التصنيف الإداري</label>
                <select name="category" required>
                    <option value="المنطقة الوسطى" <?php if($data['category'] == 'المنطقة الوسطى') echo 'selected'; ?>>المنطقة الوسطى</option>
                    <option value="المنطقة الغربية" <?php if($data['category'] == 'المنطقة الغربية') echo 'selected'; ?>>المنطقة الغربية</option>
                    <option value="المنطقة الشرقية" <?php if($data['category'] == 'المنطقة الشرقية') echo 'selected'; ?>>المنطقة الشرقية</option>
                    <option value="المنطقة الشمالية" <?php if($data['category'] == 'المنطقة الشمالية') echo 'selected'; ?>>المنطقة الشمالية</option>
                    <option value="المنطقة الجنوبية" <?php if($data['category'] == 'المنطقة الجنوبية') echo 'selected'; ?>>المنطقة الجنوبية</option>
                </select>
            </div>
        </div>

        <div class="section-title">✨ التفاصيل والخصائص</div>
        <div class="grid-inputs">
            <div class="form-group">
                <label>أهم المميزات</label>
                <input type="text" name="features" value="<?php echo $data['features']; ?>" placeholder="مثال: طبيعة، آثار...">
            </div>
            <div class="form-group">
                <label>الأنشطة المتاحة</label>
                <input type="text" name="activities" value="<?php echo $data['activities']; ?>" placeholder="مثال: هايكنج، تصوير...">
            </div>
            <div class="form-group full-width">
                <label>أبرز المعالم (افصل بينها بفاصلة)</label>
                <input type="text" name="landmarks" value="<?php echo $data['landmarks']; ?>" placeholder="مثال: قصر المصمك، الدرعية...">
            </div>
            <div class="form-group full-width">
                <label>الوصف الشامل</label>
                <textarea name="description" rows="5" required><?php echo $data['description']; ?></textarea>
            </div>
        </div>

        <div class="section-title">🖼️ إدارة الوسائط والصور</div>
        <div class="image-preview-group">
            <div class="form-group">
                <span class="image-status">✅ الصورة الرئيسية مفعلة</span>
                <input type="file" name="image_url">
            </div>
            <div class="form-group">
                <span class="image-status">🖼️ صورة المعرض 1</span>
                <input type="file" name="gallery1">
            </div>
            <div class="form-group">
                <span class="image-status">🖼️ صورة المعرض 2</span>
                <input type="file" name="gallery2">
            </div>
            <div class="form-group">
                <span class="image-status">🖼️ صورة المعرض 3</span>
                <input type="file" name="gallery3">
            </div>
        </div>
        
        <button type="submit" style="width: 100%; margin-top: 30px; font-size: 1.1rem; padding: 15px;">
             تحديث كافة البيانات بنجاح 🚀
        </button>
    </form>
    
    <div style="text-align: center; margin-top: 25px;">
        <a href="dashboard.php" class="back-link">إلغاء العملية والعودة للخلف</a>
    </div>
</div>

<footer style="text-align: center; padding: 30px; color: rgba(255,255,255,0.3); font-size: 0.8rem;">
    نظام إدارة محتوى "اكتشف السعودية" - الإصدار المتطور 2.0
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