<?php
// edit_process.php
// 해당 페이지는 수정 처리 페이지 입니다.
// 기능 - 사용자의 입력값(POST) 수집하여 DB에 저장 후 수정시간 업데이트
session_start();
require_once '../core/init.php';

// 입력값 수집 및 검증
$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    fail('알 수 없는 오류', "./index.php");
}

if ($title === '' || $content === '') {
    fail('내용을 모두 입력해주세요', './edit.php?id=' . $id);
}

// step1. DB연결
try {
    $mysqli = db_con();
    // step2. 수정 쿼리 작성
    $sql = "UPDATE posts SET title = '$title' content = '$content'
            WHERE id = $id";
    // step3. 쿼리 성공시 성공메시지 남기고, view페이지로 리디렉션
    $mysqli->query($sql);
    $_SESSION['success'] = "성공적으로 수정하였습니다.";
    exit;
} catch (Exception) {
    // 예외처리 - 실패시 view로 리디렉션
    fail('알 수 없는 오류', "./view?id=.php");
} finally {
    if ($mysqli && $mysqli instanceof mysqli) {
        $mysqli->close();
    }
}

?>