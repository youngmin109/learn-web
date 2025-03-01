<?php
include __DIR__ . "/../includes/db_connect.php";  // DB 연결

// 데이터 수신
$comment_id = (int)$_POST["comment_id"];
$password = $_POST["password"];

// 해당 댓글이 존재하는지 확인
$check_sql = "SELECT post_id, password FROM comments WHERE id = $comment_id";
$check_result = mysqli_query($con, $check_sql);
$comment = mysqli_fetch_assoc($check_result);

if (!$comment) {
    die("존재하지 않는 댓글입니다.");
}

// 비밀번호 검증
if ($comment["password"] !== $password) {
    die("비밀번호가 일치하지 않습니다.");
}

// 부모 댓글 삭제 시 대댓글까지 삭제
$delete_sql = "DELETE FROM comments WHERE id = $comment_id OR parent_id = $comment_id";
mysqli_query($con, $delete_sql);

// 삭제 후 게시글 페이지로 이동
header("Location: view.php?id=" . $comment["post_id"]);
exit();
?>
