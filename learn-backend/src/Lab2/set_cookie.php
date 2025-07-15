<?php
    if (isset($_POST['username']) && isset($_POST['latte']) && isset($_POST['americano'])){
        $username = trim($_POST['username']);
        $latte = trim($_POST['latte']);
        $americano = trim($_POST['americano']);

        setcookie("username", $username, time() + 3600, "/");
        setcookie("latte", $latte, time() + 3600, "/");
        setcookie("americano", $americano, time() + 3600, "/");
        header("Location: index.php");
        exit;
        // exit을 해주는 이유는 리다이렉트 후에 스크립트가 계속 실행되는 것을 방지
    }


?>