<?php
$name=trim($_POST['username']);
$latte=(int)$_POST['latte'];
$americano = (int)$_POST['americano'];


setcookie('username',$name,time() + 3600, '/');
setcookie('latte',$latte,time() + 3600, '/');
setcookie('americano', $americano, time() + 3600, '/');

header('Location: index.php');
exit;
?>