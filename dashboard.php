<?php require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$totalStudents = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$totalGroups = $pdo->query("SELECT COUNT(*) FROM groups")->fetchColumn();
$todayAchievements = $pdo->prepare("SELECT COUNT(*) FROM daily_achievements WHERE date = CURDATE()");
$todayAchievements->execute();
$todayCount = $todayAchievements->fetchColumn();
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar"><head><meta charset="UTF-8"><title>لوحة التحكم</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container"><div style="display: flex; justify-content: space-between; align-items: center;"><h1>📊 لوحة التحكم</h1><a href="logout.php" class="btn btn-outline">🚪 تسجيل خروج</a></div>
<div class="features-grid" style="margin-top: 2rem;"><div class="card"><h3>👩‍🎓 الطالبات</h3><p style="font-size:2rem;"><?= $totalStudents ?></p></div>
<div class="card"><h3>👥 المجموعات</h3><p style="font-size:2rem;"><?= $totalGroups ?></p></div>
<div class="card"><h3>✅ إنجازات اليوم</h3><p style="font-size:2rem;"><?= $todayCount ?></p></div></div>
<div class="features-grid">
<a href="manage_groups.php" class="card" style="text-decoration:none; color:inherit;"><h3>📁 إدارة المجموعات والمشرفات</h3><p>إضافة وتعديل وحذف المجموعات والمشرفات</p></a>
<a href="manage_students.php" class="card" style="text-decoration:none; color:inherit;"><h3>📝 إدارة الطالبات</h3><p>إضافة أو نقل أو حذف الطالبات</p></a>
<a href="record.php" class="card" style="text-decoration:none; color:inherit;"><h3>✅ تسجيل الإنجازات</h3><p>تسجيل إنجازات الطالبات اليومية بالرموز</p></a>
<a href="daily_report.php" class="card" style="text-decoration:none; color:inherit;"><h3>📆 التقارير اليومية</h3><p>عرض وتصدير تقارير اليوم</p></a>
<a href="weekly_report.php" class="card" style="text-decoration:none; color:inherit;"><h3>📅 التقارير الأسبوعية</h3><p>عرض إنجازات آخر 7 أيام</p></a>
</div></div></body></html>