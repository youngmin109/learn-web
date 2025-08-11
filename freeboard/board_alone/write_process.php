<?php
// write_process
require_once './init.php';

// 1. 입력값 수집 및 전처리
// 전처리는 name,password,title
$name = trim($_POST['name'] ?? '');
$password = trim($_POST['password'] ?? '');
$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');

// 2. 입력값 유효 값 처리
// 공백 시 fail 함수
if ($name === '' || $password === '' || $title === '' || $content === '') {
    fail('값을 모두 입력해주세요');
}

// 3. 데이터 베이스 연결
try {
    $mysqli = db_con();

    // 4. 비밀번호 해싱
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 5. SQL문 작성하여 INSERT
    $sql = "INSERT INTO posts (name, password, title, content)
    values ('$name', '$password_hash', '$title', '$content')";
    $result = $mysqli->query($sql);

    // 6. 성공 시 view.php로 이동
    $_SESSION['success'] = '게시글 작성 성공';
    header("Location: index.php"); 
    exit;

} catch (mysqli_sql_exception $e) {
    // 7. catch문 예외 처리
    // 7-1. 데이터 베이스 연결 오류
    // 7-2. 쿼리문 오류 (개발자 오류)
    error_log($e->getMessage());
    fail("게시글 저장 실패! 데이터 베이스 오류");
} finally {
    if (isset($mysqli) && $mysqli instanceof mysqli) {
        $mysqli->close();
    }
}
