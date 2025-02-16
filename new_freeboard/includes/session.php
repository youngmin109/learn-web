<?php
session_start();

// 로그인 확인
function is_logged_in() {
    return isset($_SESSION["user_id"]);
}

// 로그인한 사용자의 ID 반환
function get_user_id() {
    return $_SESSION["user_id"];
}

// 로그인한 사용자의 이름 반환
function get_username() {
    return $_SESSION["username"];
}
?>
