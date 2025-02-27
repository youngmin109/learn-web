<?php
include __DIR__ . "/../includes/db_connect.php";

// 데이터 수신
$post_id = (int)$_POST["post_id"];
$parent_id = isset($_POST["parent_id"]) && $_POST["parent_id"] != 0 ? (int)$_POST["parent_id"] : NULL;
$author = !empty($_POST["author"]) ? $_POST["author"] : "익명";
$password = $_POST["password"];
$content = $_POST["content"];

// 대댓글인 경우, 부모 댓글이 실제로 존재하는지 확인
if ($parent_id) {
    $check_sql = "SELECT id FROM comments WHERE id = $parent_id";
    $check_result = mysqli_query($con, $check_sql);
    if (mysqli_num_rows($check_result) == 0) {
        die("존재하지 않는 부모 댓글 ID입니다.");
    }
}

// 댓글 저장
$sql = "INSERT INTO comments (post_id, parent_id, author, password, content) 
        VALUES ($post_id, " . ($parent_id !== NULL ? $parent_id : "NULL") . ", '$author', '$password', '$content')";
mysqli_query($con, $sql);

// 등록 후 게시글 페이지로 이동
header("Location: view.php?id=" . $post_id);
exit();
?>
