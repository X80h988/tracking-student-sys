<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام تتبع إنجازات الطالبات</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        .hero { text-align: center; padding: 4rem 1rem; background: linear-gradient(145deg, #fff8ed, #fff); border-radius: 2rem; margin-bottom: 3rem; }
        .hero h2 { font-size: 2.2rem; margin: 1rem 0; }
        .badge-icons { display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; margin: 2rem 0; }
        .badge-icons span { background: #f1f5f9; padding: 0.5rem 1rem; border-radius: 3rem; font-size: 1.2rem; }
        .btn-large { padding: 1rem 2.5rem; font-size: 1.2rem; }
    </style>
</head>
<body>
<div class="container">
    <div class="hero">
        <h1>📚 نظام تتبع إنجازات الطالبات</h1>
        <div class="badge-icons">
            <span>📺 فصل الخطاب</span>
            <span>📹 الفيديوهات المرفقة</span>
            <span>📄 المقالات</span>
        </div>
        <h2>جاهزة للبدء؟</h2>
        <p>انضم إلينا الآن وابدأ في تتبع إنجازات طالباتك بكفاءة</p>
        <a href="login.php" class="btn btn-primary btn-large" style="margin-top: 1.5rem;">🚪 تسجيل الدخول</a>
    </div>
    <div class="features-grid">
        <div class="card"><div class="feature-icon">👥</div><h3>إدارة المجموعات</h3><p>أنشئ مجموعات دراسية وأضف الطالبات بسهولة، مع تعيين مشرفة لكل مجموعة</p></div>
        <div class="card"><div class="feature-icon">✅</div><h3>تسجيل الإنجازات</h3><p>سجل إنجازات الطالبات باستخدام رموز تعبيرية بسيطة وحفظ تلقائي</p></div>
        <div class="card"><div class="feature-icon">📊</div><h3>التقارير المنسقة</h3><p>توليد تقارير يومية وأسبوعية منسقة وجاهزة للمشاركة بنقرة واحدة</p></div>
    </div>
    <div style="text-align: center; margin: 2rem 0;">
        <div style="display: flex; justify-content: center; gap: 1.5rem; flex-wrap: wrap;">
            <span class="achievement-badge">⭐ إنهاء الورد</span>
            <span class="achievement-badge">🌙 إنهاء ٥ أوراد</span>
            <span class="achievement-badge">🏮 إنهاء الكتاب</span>
        </div>
    </div>
    <footer style="text-align: center; margin-top: 3rem; color: #6c757d;">Made with safaa❤️ | نظام تتبع إنجازات الطالبات</footer>
</div>
</body>
</html>