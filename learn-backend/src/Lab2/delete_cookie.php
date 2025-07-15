<?php
    setcookie("username", "", time() - 3600, "/");
    setcookie("latte", "", time() - 3600, "/");
    setcookie("americano", "", time() - 3600, "/");
    header("Location: index.php");
    exit;
?>