<?php
session_start(); // 세션 시작

// **한국 시간(KST)으로 설정**
date_default_timezone_set("Asia/Seoul");

// 로그인 여부 확인 (비로그인 사용자는 글 작성 불가)
if (!isset($_SESSION["user_id"])) {
    die("로그인 후 글을 작성할 수 있습니다.");
}

// 사용자가 입력한 데이터 받기 (POST 값이 없을 경우 빈 문자열로 초기화)
$user_id = $_SESSION["user_id"]; // 로그인한 사용자의 ID
$subject = isset($_POST["subject"]) ? $_POST["subject"] : "";
$content = isset($_POST["content"]) ? $_POST["content"] : "";
$regist_day = date("Y-m-d H:i:s");  // '년-월-일 시:분:초' 형식으로 저장

// HTML 특수문자 변환 (보안 강화)
$subject = htmlspecialchars($subject, ENT_QUOTES);
$content = htmlspecialchars($content, ENT_QUOTES);

// MySQL 데이터베이스 연결
$con = mysqli_connect("localhost", "user", "12345", "user");

// SQL 실행 (pass 컬럼 제거)
$sql = "INSERT INTO freeboard (user_id, subject, content, regist_day) 
        VALUES ('$user_id', '$subject', '$content', '$regist_day')";

if (mysqli_query($con, $sql)) {
    // 글 작성 성공 시 목록 페이지로 이동
    header("Location: list.php");
    exit();
} else {
    echo "글 작성 실패: " . mysqli_error($con);
}

mysqli_close($con);
?>
