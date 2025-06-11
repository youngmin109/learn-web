<?php
include __DIR__ . "/../includes/db_connect.php";
include __DIR__ . "/../includes/session.php";

// `POST` 방식으로 전달된 값 받기
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("잘못된 접근입니다.");
}

$num = $_POST["num"];
$subject = mysqli_real_escape_string($con, $_POST["subject"]);
$content = mysqli_real_escape_string($con, $_POST["content"]);

// 해당 글이 로그인한 사용자의 글인지 확인
$sql = "SELECT user_id FROM freeboard WHERE num = $num";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row || get_user_id() != $row["user_id"]) {
    die("수정 권한이 없습니다.");
}

// 수정된 내용 업데이트
$sql = "UPDATE freeboard SET subject = '$subject', content = '$content' WHERE num = $num";
mysqli_query($con, $sql);

header("Location: view.php?num=$num");
exit();
?>
