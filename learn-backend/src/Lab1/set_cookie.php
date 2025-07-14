<?php
if (isset($_POST['username'])) {
    $username = trim($_POST['username']);
    setcookie("username", $username, time() + 3600, "/");
    header("Location: index.php");
    exit;
}
?>