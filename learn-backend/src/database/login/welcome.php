<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<h2>환영합니다, <?= htmlspecialchars($_SESSION['name']) ?>님!</h2>
<a href="logout.php">로그아웃</a>
