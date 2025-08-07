<?php
session_start();
if (isset($_SESSION['success'])) {
    echo $_SESSION['success'];
    unset($_SESSION['success']);
}

// user_id 존재 확인
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

echo "<br>반갑습네다. {$_SESSION['name']}님!";

// 로그아웃
echo "<p><a href='logout.php'>로그아웃</a></p>";
?>