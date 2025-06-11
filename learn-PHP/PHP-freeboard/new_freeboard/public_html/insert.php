<?php
include __DIR__ . "/../includes/db_connect.php";
include __DIR__ . "/../includes/session.php";

// 로그인 확인
if (!is_logged_in()) {
    die("로그인 후 글을 작성할 수 있습니다.");
}

// 사용자 입력 데이터 받기
$user_id = get_user_id();
$subject = mysqli_real_escape_string($con, $_POST["subject"]);
$content = mysqli_real_escape_string($con, $_POST["content"]);
$regist_day = date("Y-m-d H:i:s");

// SQL 실행
$sql = "INSERT INTO freeboard (user_id, subject, content, regist_day) 
        VALUES ('$user_id', '$subject', '$content', '$regist_day')";
if (mysqli_query($con, $sql)) {
    header("Location: list.php");
    exit();
} else {
    echo "글 작성 실패: " . mysqli_error($con);
}

mysqli_close($con);
?>
