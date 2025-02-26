
<?php
include __DIR__ . "/../includes/db_connect.php";

// 데이터 수신
$post_id = (int)$_POST["post_id"];
// 최상위 댓글일 경우, POST 값이 "0"으로 넘어오면 null 처리
$parent_id = isset($_POST["parent_id"]) ? (int)$_POST["parent_id"] : null;
$author = !empty($_POST["author"]) ? $_POST["author"] : "익명";
$password = $_POST["password"];
$content = $_POST["content"];

// 만약 parent_id가 0이면 최상위 댓글로 간주하여 null로 처리
if ($parent_id === 0) {
    $parent_id = "NULL";  // SQL에서 NULL로 넣기 위해 문자열 "NULL" 사용
} else {
    // 대댓글인 경우, 부모 댓글이 실제로 존재하는지 확인
    $check_sql = "SELECT id FROM comments WHERE id = $parent_id";
    $check_result = mysqli_query($con, $check_sql);
    if (mysqli_num_rows($check_result) == 0) {
        die("존재하지 않는 부모 댓글 ID입니다.");
    }
}

// 댓글 저장 (parent_id가 "NULL"인 경우에는 그대로, 아니면 숫자로 삽입)
if ($parent_id === "NULL") {
    $sql = "INSERT INTO comments (post_id, parent_id, author, password, content) 
            VALUES ($post_id, NULL, '$author', '$password', '$content')";
} else {
    $sql = "INSERT INTO comments (post_id, parent_id, author, password, content) 
            VALUES ($post_id, $parent_id, '$author', '$password', '$content')";
}

mysqli_query($con, $sql);
header("Location: view.php?id=$post_id");
exit();
?>
