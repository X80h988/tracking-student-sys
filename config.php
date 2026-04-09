<?php
session_start();

// نفحص إذا كنا على منصة Railway (توجد متغيرات البيئة)
if (getenv('MYSQLHOST')) {
    $host = getenv('MYSQLHOST');
    $dbname = getenv('MYSQLDATABASE');
    $user = getenv('MYSQLUSER');
    $pass = getenv('MYSQLPASSWORD');
} else {
    // بيانات الاتصال على جهازك المحلي (XAMPP)
    $host = 'localhost';
    $dbname = 'tracking_system';
    $user = 'root';
    $pass = '';
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>