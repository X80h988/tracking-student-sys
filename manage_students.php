<?php require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$groups = $pdo->query("SELECT * FROM groups")->fetchAll();
$selected_group = $_GET['group_id'] ?? ($groups[0]['id'] ?? 0);
$students = [];
if ($selected_group) { $stmt = $pdo->prepare("SELECT * FROM students WHERE group_id = ? ORDER BY name"); $stmt->execute([$selected_group]); $students = $stmt->fetchAll(); }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $pdo->prepare("INSERT INTO students (name, group_id) VALUES (?, ?)")->execute([$_POST['student_name'], $_POST['group_id']]);
    header("Location: manage_students.php?group_id=".$_POST['group_id']); exit;
}
if (isset($_GET['delete_student'])) {
    $pdo->prepare("DELETE FROM students WHERE id = ?")->execute([$_GET['delete_student']]);
    header("Location: manage_students.php?group_id=$selected_group"); exit;
}
?>
<!DOCTYPE html><html dir="rtl"><head><meta charset="UTF-8"><title>إدارة الطالبات</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container"><div class="card"><h2>📝 إدارة الطالبات</h2><div class="action-bar"><label>اختر المجموعة:</label><select onchange="window.location.href='?group_id='+this.value"><?php foreach ($groups as $g): ?><option value="<?= $g['id'] ?>" <?= $selected_group == $g['id'] ? 'selected' : '' ?>><?= htmlspecialchars($g['name']) ?></option><?php endforeach; ?></select></div>
<form method="POST" style="display:flex; gap:1rem; margin:1rem 0;"><input type="hidden" name="group_id" value="<?= $selected_group ?>"><input type="text" name="student_name" placeholder="اسم الطالبة" class="form-control" required style="flex:2"><button type="submit" name="add_student" class="btn btn-primary">➕ إضافة طالبة</button></form>
<table class="data-table"><tr><th>#</th><th>اسم الطالبة</th><th>إجراء</th></tr><?php foreach ($students as $idx => $s): ?><tr><td><?= $idx+1 ?></td><td><?= htmlspecialchars($s['name']) ?></td><td><a href="?delete_student=<?= $s['id'] ?>&group_id=<?= $selected_group ?>" onclick="return confirm('حذف الطالبة سيؤدي لحذف إنجازاتها. متأكدة؟')" style="color:red;">🗑️ حذف</a></td></tr><?php endforeach; ?></table>
<a href="dashboard.php" class="btn btn-outline">⬅️ العودة</a></div></div></body></html>