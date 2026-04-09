<?php require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$groups = $pdo->query("SELECT g.*, s.name as supervisor_name FROM groups g LEFT JOIN supervisors s ON g.supervisor_id = s.id")->fetchAll();
$achievements = $pdo->query("SELECT * FROM achievements ORDER BY id")->fetchAll();
$selected_group = isset($_GET['group_id']) ? (int)$_GET['group_id'] : ($groups[0]['id'] ?? 0);
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$students = [];
if ($selected_group) { $stmt = $pdo->prepare("SELECT * FROM students WHERE group_id = ? ORDER BY name"); $stmt->execute([$selected_group]); $students = $stmt->fetchAll(); }
$recorded = [];
if ($selected_group && !empty($students)) {
    $ids = array_column($students, 'id'); $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT student_id, achievement_id FROM daily_achievements WHERE date = ? AND student_id IN ($placeholders)");
    $stmt->execute(array_merge([$selected_date], $ids));
    foreach ($stmt->fetchAll() as $row) { $recorded[$row['student_id']][$row['achievement_id']] = true; }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $date = $_POST['date']; $del = $pdo->prepare("DELETE FROM daily_achievements WHERE date = ? AND student_id IN (SELECT id FROM students WHERE group_id = ?)");
    $del->execute([$date, $selected_group]);
    if (!empty($_POST['achievements'])) { $insert = $pdo->prepare("INSERT INTO daily_achievements (student_id, achievement_id, date) VALUES (?, ?, ?)");
        foreach ($_POST['achievements'] as $student_id => $ach_ids) { foreach ($ach_ids as $ach_id) { $insert->execute([$student_id, $ach_id, $date]); } } }
    echo "<script>alert('تم حفظ الإنجازات بنجاح'); window.location.href='?group_id=$selected_group&date=$date';</script>";
}
?>
<!DOCTYPE html><html dir="rtl"><head><meta charset="UTF-8"><title>تسجيل الإنجازات</title><link rel="stylesheet" href="style.css"><style>.symbol-checkbox{display:inline-flex;align-items:center;gap:5px;background:#f8fafc;padding:5px 10px;border-radius:30px;margin:3px;cursor:pointer}.symbol-checkbox input{width:18px;height:18px;margin-left:5px;cursor:pointer}.student-row:hover{background:#fef9e6}</style></head>
<body><div class="container"><div class="card"><div style="display:flex;justify-content:space-between;"><h2>✅ تسجيل إنجازات الطالبات</h2><a href="dashboard.php" class="btn btn-outline">🏠 الرئيسية</a></div>
<div class="action-bar"><label>📌 المجموعة:</label><select onchange="window.location.href='?group_id='+this.value+'&date=<?= $selected_date ?>'"><?php foreach ($groups as $g): ?><option value="<?= $g['id'] ?>" <?= $selected_group == $g['id'] ? 'selected' : '' ?>><?= htmlspecialchars($g['name']) ?> (مشرفة: <?= htmlspecialchars($g['supervisor_name'] ?? 'غير محدد') ?>)</option><?php endforeach; ?></select><label>📅 التاريخ:</label><input type="date" value="<?= $selected_date ?>" onchange="window.location.href='?group_id=<?= $selected_group ?>&date='+this.value"></div>
<?php if ($selected_group && !empty($students)): ?><form method="POST"><input type="hidden" name="date" value="<?= $selected_date ?>"><table class="data-table"><thead><tr><th>#</th><th>الطالبة</th><?php foreach ($achievements as $ach): ?><th><?= $ach['symbol'] ?> <?= $ach['name'] ?></th><?php endforeach; ?></tr></thead><tbody><?php foreach ($students as $idx => $student): ?><tr class="student-row"><td><?= $idx+1 ?></td><td style="font-weight:bold;"><?= htmlspecialchars($student['name']) ?></td><?php foreach ($achievements as $ach): ?><?php $checked = isset($recorded[$student['id']][$ach['id']]) ? 'checked' : ''; ?><td><label class="symbol-checkbox"><input type="checkbox" name="achievements[<?= $student['id'] ?>][]" value="<?= $ach['id'] ?>" <?= $checked ?>><span><?= $ach['symbol'] ?></span></label></td><?php endforeach; ?></tr><?php endforeach; ?></tbody></table><div style="text-align:left; margin-top:1.5rem;"><button type="submit" name="save" class="btn btn-primary">💾 حفظ الإنجازات</button></div></form><?php else: ?><div class="alert alert-error">لا توجد طالبات في هذه المجموعة. يرجى إضافة طالبات أولاً.</div><?php endif; ?></div></div></body></html>