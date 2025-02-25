<?php

$host = "localhost";
$user = "user";
$pass = "12345";
$database = "file_comment_freeboard";

$con = mysqli_connect($host, $user, $pass, $database);

if (!$con) {
    die ("연결 실패: " . mysqli_connect_error());
}

// 한글 깨짐 방지 
mysqli_set_charset($con, "utf8");

?>
