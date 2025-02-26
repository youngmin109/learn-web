<?php
include __DIR__ . "/../includes/db.connect.php";

$title = $_POST["title"];
$author = $_POST["author"];
$password = $_POST["password"];
$content = $_POST["content"];

$sql = "INSERT INTO freeboard (title, author, password, content)
        VALUES ('$title', '$author', '$password', '$content')";
mysqli_query($con, $sql);

// 방금 입력한 게시글 ID
$post_id = mysqli_insert_id($con);

// 파일 업로드 처리
if (!empty($_FILES["file"]["name"])) {
    $original_name = $_FILES["file"]["name"];
    $stored_name = uniqid() . "_" . $original_name; // 저장 파일명 생성
    move_uploaded_file($_FILES["file"]["tmp_name"], "../uploads" . $stored_name);

    // 파일 정보 저장
    $file_sql = "INSERT INTO files (post_id, original_name, stored_name)
                VALUES ('$post_id', '$original_name', '$stored_name')";
}

// 목록으로 이동
header("Location : index.php");
exit();
?>