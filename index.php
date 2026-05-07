<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>اكتشف السعودية - الرئيسية</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
    <div class="logo">اكتشف السعودية</div>
    <div class="nav-links">
        <a href="index.php">الرئيسية</a>
        <a href="#explore">معرض المناطق</a>
        <a href="login.php">دخول المشرف</a>
        
        <span id="theme-toggle" style="cursor: pointer; font-size: 1.2rem; margin-right: 15px; user-select: none;">
            🌙
        </span>
    </div>
</nav>

    <header class="hero-banner">
        <div class="hero-text" style="padding: 50px 5%;">
            <h2>موقع ثقافي تفاعلي للتعريف بالمملكة</h2>
            <p>استكشف معالم المملكة التاريخية والثقافية.</p>
            <a href="#explore" class="view-btn" style="width: fit-content; border-radius: 5px;">ابدأ الاستكشاف</a>
        </div>
    </header>

    <section class="info-cards-container">
    <div class="info-box">
        <h3>🌟 الهدف</h3>
        <p>تقديم معلومات عربية موثقة عن مناطق المملكة وأبرز الوجهات.</p>
    </div>
    
    <div class="info-box">
        <h3>🗺️ المناطق</h3>
        <p>معرض تفاعلي ينقل المستخدم بين المناطق (صور + عناوين + روابط).</p>
    </div>
    
    <div class="info-box">
        <h3>📜 التفاصيل</h3>
        <p>صفحة لعرض وصفاً وصوراً ومعلومات تاريخية عن المكان المختار.</p>
    </div>
    </section>

    

    <h2 id="explore" style="text-align: center; margin-top: 50px;">📍 استكشف المناطق</h2>
    
    <main class="content-grid">
        <?php
        $result = $conn->query("SELECT * FROM content ORDER BY id DESC");
        while($row = $result->fetch_assoc()): ?>
            <div class="public-card">
                <img src="images/<?php echo $row['image_url']; ?>" style="width:100%; height:200px; object-fit:cover;">
                <div class="public-card-body">
                    <h3><?php echo $row['name']; ?></h3>
                    <p><?php echo mb_strimwidth($row['description'], 0, 100, "..."); ?></p>
                    <a href="details.php?id=<?php echo $row['id']; ?>" class="view-btn">عرض التفاصيل</a>
                </div>
            </div>
        <?php endwhile; ?>
    </main>

    <footer style="text-align: center; padding: 40px;">
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