<?php
include __DIR__ . "/../includes/db_connect.php";  // DB 연결

// 데이터 수신
$comment_id = (int)$_POST["comment_id"];
$password = $_POST["password"];

// 해당 댓글이 존재하는지 확인
$check_sql = "SELECT * FROM comments WHERE id = $comment_id";
$check_result = mysqli_query($con, $check_sql);
$comment = mysqli_fetch_assoc($check_result);

if (!$comment) {
    die("존재하지 않는 댓글입니다.");
}

// 비밀번호 검증
if ($comment["password"] !== $password) {
    die("비밀번호가 일치하지 않습니다.");
}

// 대댓글이 존재하는지 확인
$reply_check_sql = "SELECT id FROM comments WHERE parent_id = $comment_id";
$reply_check_result = mysqli_query($con, $reply_check_sql);

if (mysqli_num_rows($reply_check_result) > 0) {
    die("대댓글이 있는 댓글은 삭제할 수 없습니다.");
}

// 댓글 삭제
$delete_sql = "DELETE FROM comments WHERE id = $comment_id";
mysqli_query($con, $delete_sql);

// 삭제 후 게시글 페이지로 이동
header("Location: view.php?id=" . $comment["post_id"]);
exit();
