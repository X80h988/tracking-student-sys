<?php require_once 'config.php';
if (!isset($_SESSION['user_id']))
     { header('Location: login.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_group'])) {
    $name = $_POST['group_name']; $supervisor_id = $_POST['supervisor_id'] ?: null;
    $pdo->prepare("INSERT INTO groups (name, supervisor_id) VALUES (?, ?)")->execute([$name, $supervisor_id]);
    header('Location: manage_groups.php'); exit;
}
if (isset($_GET['delete_group'])) {
    $pdo->prepare("DELETE FROM groups WHERE id = ?")->execute([$_GET['delete_group']]);
    header('Location: manage_groups.php'); exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_supervisor'])) {
    $pdo->prepare("INSERT INTO supervisors (name, email, phone) VALUES (?, ?, ?)")->execute([$_POST['sup_name'], $_POST['sup_email'], $_POST['sup_phone']]);
    header('Location: manage_groups.php'); exit;
}
$groups = $pdo->query("SELECT g.*, s.name as supervisor_name FROM groups g LEFT JOIN supervisors s ON g.supervisor_id = s.id")->fetchAll();
$supervisors = $pdo->query("SELECT * FROM supervisors")->fetchAll();
?>
<!DOCTYPE html><html dir="rtl"><head><meta charset="UTF-8"><title>إدارة المجموعات</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container"><div class="card"><h2>📁 إدارة المجموعات</h2>
<form method="POST" style="display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:2rem;"><input type="text" name="group_name" placeholder="اسم المجموعة" class="form-control" required style="flex:1"><select name="supervisor_id" class="form-control"><option value="">بدون مشرفة</option><?php foreach ($supervisors as $sup): ?><option value="<?= $sup['id'] ?>"><?= htmlspecialchars($sup['name']) ?></option><?php endforeach; ?></select><button type="submit" name="add_group" class="btn btn-primary">➕ إضافة مجموعة</button></form>
<table class="data-table"><tr><th>المجموعة</th><th>المشرفة</th><th>إجراء</th></tr><?php foreach ($groups as $g): ?><tr><td><?= htmlspecialchars($g['name']) ?></td><td><?= htmlspecialchars($g['supervisor_name'] ?? '—') ?></td><td><a href="?delete_group=<?= $g['id'] ?>" onclick="return confirm('حذف المجموعة سيحذف جميع طالباتها. متأكدة؟')" style="color:red;">🗑️ حذف</a></td></tr><?php endforeach; ?></table></div>
<div class="card" style="margin-top:2rem;"><h2>👩‍🏫 إدارة المشرفات</h2><form method="POST" style="display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:1rem;"><input type="text" name="sup_name" placeholder="الاسم الكامل" class="form-control" required><input type="email" name="sup_email" placeholder="البريد الإلكتروني" class="form-control"><input type="text" name="sup_phone" placeholder="الهاتف" class="form-control"><button type="submit" name="add_supervisor" class="btn btn-primary">➕ إضافة مشرفة</button></form>
<table class="data-table"><tr><th>الاسم</th><th>البريد</th><th>الهاتف</th></tr><?php foreach ($supervisors as $sup): ?><tr><td><?= htmlspecialchars($sup['name']) ?></td><td><?= htmlspecialchars($sup['email']) ?></td><td><?= htmlspecialchars($sup['phone']) ?></td></tr><?php endforeach; ?></table></div>
<a href="dashboard.php" class="btn btn-outline">⬅️ العودة</a></div></body></html>