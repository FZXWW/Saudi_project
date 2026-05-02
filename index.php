<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>اكتشف السعودية - الرئيسية</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* لضمان عمل الهيكل الجديد مع flex الـ body القديم */
        body { display: block; height: auto; align-items: initial; justify-content: initial; }
    </style>
</head>
<body>

    <!-- شريط التنقل العلوي -->
    <nav class="navbar">
        <div class="logo">اكتشف السعودية</div>
        <div class="nav-links">
            <a href="index.php">الرئيسية</a>
            <a href="#explore">معرض المناطق</a>
            <a href="login.php">دخول المشرف</a>
        </div>
    </nav>

    <!-- قسم الترحيب (Hero) -->
    <header class="hero-banner">
        <div class="hero-text" style="flex: 1.5;">
            <h2 style="color: var(--primary-color);">موقع ثقافي تفاعلي للتعريف بالمملكة</h2>
            <p>استكشف مناطق المملكة العربية السعودية وتعرف على أهم المعالم التاريخية والثقافية. اختر منطقة من المعرض للانتقال إلى صفحة التفاصيل.</p>
            <a href="#explore" class="btn-add" style="display:inline-block; margin-top:20px; float:none;">ابدأ الاستكشاف</a>
        </div>
        <div class="hero-image-box">أهلاً بك 👋</div>
    </header>

    <!-- أقسام التعريف الثلاثة (الهدف، المناطق، التفاصيل) -->
    <section class="info-cards-container">
        <div class="info-box">
            <h3>🌟 الهدف</h3>
            <p>تقديم معلومات موثقة عن معالم المملكة العربية السعودية.</p>
        </div>
        <div class="info-box">
            <h3>🗺️ المناطق</h3>
            <p>معرض تفاعلي يسهل التنقل بين المناطق والبحث عن الوجهات.</p>
        </div>
        <div class="info-box">
            <h3>📜 التفاصيل</h3>
            <p>صفحات مخصصة لعرض وصف تفصيلي ومعلومات تاريخية غنية.</p>
        </div>
    </section>

    <!-- معرض المناطق الديناميكي -->
    <h2 id="explore" style="text-align: center; color: var(--primary-color); margin: 50px 0 20px;">📍 استكشف المناطق</h2>
    
    <main class="content-grid">
        <?php
        $result = $conn->query("SELECT * FROM content ORDER BY id DESC");
        while($row = $result->fetch_assoc()): ?>
            <div class="public-card">
                <div class="public-card-body">
                    <span class="category-badge"><?php echo $row['category']; ?></span>
                    <h3><?php echo $row['name']; ?></h3>
                    <p><?php echo mb_strimwidth($row['description'], 0, 100, "..."); ?></p>
                </div>
                <a href="details.php?id=<?php echo $row['id']; ?>" class="view-btn">عرض التفاصيل</a>
            </div>
        <?php endwhile; ?>
    </main>

    <footer style="text-align: center; padding: 40px; color: #888; border-top: 1px solid #444; margin-top: 50px;">
        <p>© 2026 اكتشف السعودية — جامعة الملك سعود</p>
    </footer>

</body>
</html>