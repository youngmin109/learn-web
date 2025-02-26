<?php
include __DIR__ . "/../includes/db_connect.php"; 

// GET 요청에서 파일명 확인
if (!isset($_GET["file"])) {
    die("잘못된 접근입니다.");
}

$stored_name = basename($_GET["file"]); // 보안상 basename 사용
$file_path = __DIR__ . "/../uploads/" . $stored_name; // 실제 저장된 위치

// 파일이 존재하는지 확인
if (!file_exists($file_path)) {
    die("파일이 존재하지 않습니다.");
}

// 파일 다운로드 처리
header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . urlencode($stored_name));
header("Content-Length: " . filesize($file_path));
readfile($file_path);
exit();
?>
