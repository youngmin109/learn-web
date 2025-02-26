<?php
include __DIR__ . "/../includes/db_connect.php";  // DB 연결

// 데이터 수신
$title = $_POST["title"];
$author = $_POST["author"];
$password = $_POST["password"];
$content = $_POST["content"];

// 게시글 저장
$sql = "INSERT INTO freeboard (title, author, password, content) VALUES ('$title', '$author', '$password', '$content')";
mysqli_query($con, $sql);
$post_id = mysqli_insert_id($con);  // 삽입된 게시글 ID 가져오기

// 파일 업로드 처리
if (!empty($_FILES["file"]["name"])) {
    $original_name = $_FILES["file"]["name"];
    $stored_name = uniqid
    () . "_" . $original_name;  // 중복 방지를 위해 타임스탬프 추가
    $upload_path = __DIR__ . "/../uploads/" . $stored_name;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path)) {
        // 파일 정보 DB 저장
        $file_sql = "INSERT INTO files (post_id, original_name, stored_name) VALUES ($post_id, '$original_name', '$stored_name')";
        mysqli_query($con, $file_sql);
    }
}

// 게시글 목록으로 이동
header("Location: index.php");
exit();
