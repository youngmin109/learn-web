<?php
// 게시글 번호(num) 가져오기
if (!isset($_POST["num"])) {
    die("잘못된 접근입니다.");
}

// 사용자가 입력한 데이터 가져오기

$num = $_POST["num"];
$name = $_POST["name"];
$pass = $_POST["pass"];
$subject = $_POST["subject"];
$content = $_POST["content"];

// HTML 특수문자 변환 (XSS 방지)
$subject = htmlspecialchars($subject, ENT_QUOTES);
$content = htmlspecialchars($content, ENT_QUOTES);

// 한국 시간대로 설정 후 현재 시간 저장
date_default_timezone_set("Asia/Seoul");
$regist_day = date("Y-m-d H:i:s");

// 데이터베이스 연결
$con = mysqli_connect("localhost", "user", "12345", "sample");

// 게시글 수정 SQL 실행
$sql = "UPDATE freeboard 
        SET name='$name', pass='$pass', subject='$subject', content='$content', regist_day='$regist_day' 
        WHERE num=$num";
mysqli_query($con, $sql);

// DB 연결 종료
mysqli_close($con);

// 수정 완료 후 게시판 목록으로 이동
header("Location: list.php");
exit();
?>
