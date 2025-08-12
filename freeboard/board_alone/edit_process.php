<?php
// 공통 설정
require_once './init.php';

// // 입력값 수집
// $id = isset($_POST['id']) ? $_POST['id'] : '';
// $password = isset($_POST['password']) ? trim($_POST['password']) : '';

// 1. 입력값 수집 및 전처리
$id = isset($_POST['id']) ? (int)$_POST['id'] : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// 2. 입력값 유효성 검사
if ($id === '' || $password === '') {
    fail("잘못된 게시글 요청", "index.php");
}

$name = $_POST['name'];
$title = $_POST['title'];
$content = $_POST['content'];

if ($id === '' || $password === '') {
    fail('잘못된 게시글 요청', "edit.php?id=$id");
}
// DB 연결
try {
    $mysqli = db_con();

    // 비밀번호 검증
    $sql = "SELECT password FROM posts WHERE id=$id";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();

    $hash = $row['password'];

    if (!password_verify($password, $hash)) {
        fail('비밀번호가 틀립니다.', "edit.php?id=$id");
    }

    // 입력값 수정
    $sql = "UPDATE posts SET name='$name', title='$title', content='$content' 
    WHERE id=$id";
    $result = $mysqli->query($sql);

    $_SESSION['success'] = "게시글 수정 성공!";
    header("Location: view.php?id={$id}");
    exit;

    // 예외 처리
} catch (Exception $e) {
    error_log($e->getMessage());
    fail('게시글 수정 실패', "view.php?id=$id");
} finally {
    $mysqli->close();
}
