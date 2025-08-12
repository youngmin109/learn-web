<?php
// 공통 설정
require_once './init.php';
session_start();

// 1. 입력값 수집 및 전처리
$id = isset($_POST['id']) ? (int)$_POST['id'] : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// 2. 입력값 유효성 검사
if ($id === '' || $password === '') {
    fail("잘못된 게시글 요청", "index.php");
}

// 3. (try문) DB 연결
try {
    $mysqli = db_con();
    // 3-1 비밀번호 검증 (입력값 - 해시화)
    // sql문 작성 
    $sql = "SELECT password FROM posts WHERE id=$id";
    $result = $mysqli->query($sql);

    // 행 유무 검사
    if ($result->num_rows === 0) {
        fail("비밀번호가 틀립니다.", "./delete.php?id=$id");
    }
    $row = $result->fetch_assoc();
    // fetch는 무조건 연관배열로 돌려주기 때문에 문자열로 꺼내기
    $password_hash = $row['password'];
    if (!password_verify($password, $password_hash)) {
        fail('비밀번호가 틀립니다.', "delete.php?id=$id");
    }

    // 3-2 검증 완료 후
    // DELETE 후 삭제
    // 삭제 완료 후 index.php 로 이동
    $del = "DELETE FROM posts WHERE id=$id";
    $result = $mysqli->query($del);

    // 삭제 성공
    $_SESSION['success'] = "성공적으로 글을 삭제하였습니다.";
    header("Location: index.php");
    exit;
} catch (mysqli_sql_exception $e) {
    // 4. (catch문) 예외 처리
    error_log($e->getMessage());
    fail('삭제 처리 중 오류', "delete.php?id=$id");
} finally {
    // 5. (finally문)
    if (isset($mysqli) && $mysqli instanceof mysqli) {
        $mysqli->close();
    }
}
