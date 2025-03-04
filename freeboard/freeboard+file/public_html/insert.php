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

// POST와 같은 배열 요소로 값들이 저장된다.
// 같은 초전역 변수로 스크립트로 데이터를 전달하는 역할을 한다.
// 파일 업로드 처리
if (!empty($_FILES["file"]["name"])) {
    // "name" => "example.jpg",         // 메타데이터 (파일명)
    // "type" => "image/jpeg",          // 메타데이터 (파일 타입)
    // "tmp_name" => "/tmp/php12345.tmp",  // 실제 바이너리 파일 (임시 저장된 파일)
    // "error" => 0,                    // 오류 코드 (0이면 정상)
    // "size" => 1048576                 // 메타데이터 (파일 크기)

    $original_name = $_FILES["file"]["name"];
    $stored_name = uniqid() . "_" . $original_name;  // 중복 방지
    $upload_path = __DIR__ . "/../uploads/" . $stored_name;

    // 최종저장
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path)) {
        // 파일 정보 DB 저장
        $file_sql = "INSERT INTO files (post_id, original_name, stored_name) VALUES ($post_id, '$original_name', '$stored_name')";
        mysqli_query($con, $file_sql);
    }
}

// 게시글 목록으로 이동
header("Location: index.php");
exit();
