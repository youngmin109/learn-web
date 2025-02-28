<?php
include __DIR__ . "/../includes/db_connect.php";  // DB 연결

// 데이터 수신
$id = (int)$_POST["id"];
$password = $_POST["password"];

// 게시글 정보 가져오기 
$check_sql = "SELECT * FROM freeboard WHERE id = $id";
$check_result = mysqli_query($con, $check_sql);
$post = mysqli_fetch_assoc($check_result);

// 게시글 존재 여부 확인
if (!$post) {
    die("존재하지 않는 게시글입니다.");
}

// 비밀번호 검증
if ($post["password"] !== $password) {
    die("비밀번호가 일치하지 않습니다.");
}

// 첨부 파일 정보 가져오기
$file_sql = "SELECT * FROM files WHERE post_id = $id";
$file_result = mysqli_query($con, $file_sql);

// 파일 삭제
while ($file = mysqli_fetch_assoc($file_result)) {
    $file_path = __DIR__ . "/../uploads/" . $file["stored_name"];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

// 게시글 삭제 (파일도 함께 삭제됨)
$delete_sql = "DELETE FROM freeboard WHERE id = $id";
mysqli_query($con, $delete_sql);

// 목록으로 이동
header("Location: index.php");
exit();
