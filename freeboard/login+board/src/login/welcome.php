<?php
session_start();
$username = $_SESSION['username'];
$name = $_SESSION['name'];
echo "환영합니다. $name 님";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
</head>
<body>
    
</body>
</html>