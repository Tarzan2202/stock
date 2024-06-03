<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="text-align: center;">
    Welocme
    <a href="../logout.php" onclick="loadPage('register.php')">logout</a>
</body>
</html>
<?php
session_start();
if(isset($_SESSION['username'])) {
    $dsn = 'mysql:host=localhost;dbname=stock';
    $username = 'root';
    $password = '';
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("การเชื่อมต่อล้มเหลว: " . $e->getMessage());
    }
} else {
    echo "คุณต้องเข้าสู่ระบบเพื่อเข้าถึงหน้านี้";
    header("Location: ../index.php");
}
?>