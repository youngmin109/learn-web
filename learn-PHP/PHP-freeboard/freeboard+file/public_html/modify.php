<?php
include __DIR__ . "/../includes/db_connect.php";  // DB 연결

// 데이터 수신
$id = (int)$_POST["id"];
$title = $_POST["title"];
$author = $_POST["author"];
$password = $_POST["password"];
$content = $_POST["content"];
$delete_file = isset($_POST["delete_file"]);

// 게시글 가져오기
$sql = "SELECT * FROM freeboard WHERE id = $id";
$result = mysqli_query($con, $sql);
$post = mysqli_fetch_assoc($result);

if (!$post) {
    die("게시글이 존재하지 않습니다.");
}

// 비밀번호 검증
if ($post["password"] !== $password) {
    die("비밀번호가 일치하지 않습니다.");
}

// 게시글 업데이트
$update_sql = "UPDATE freeboard SET title = '$title', author = '$author', content = '$content' WHERE id = $id";
mysqli_query($con, $update_sql);

// 파일 관련 처리
$file_sql = "SELECT * FROM files WHERE post_id = $id";
$file_result = mysqli_query($con, $file_sql);
$file = mysqli_fetch_assoc($file_result);

// 파일 삭제 요청이 있을 경우
if ($delete_file && $file) {
    $file_path = __DIR__ . "/../uploads/" . $file["stored_name"];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    $delete_file_sql = "DELETE FROM files WHERE post_id = $id";
    mysqli_query($con, $delete_file_sql);
}

// 새 파일 업로드
if (!empty($_FILES["file"]["name"])) {
    $original_name = $_FILES["file"]["name"];
    $stored_name = time() . "_" . $original_name;
    $upload_path = __DIR__ . "/../uploads/" . $stored_name;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path)) {
        // 기존 파일 삭제 후 새로운 파일 등록
        if ($file) {
            $old_file_path = __DIR__ . "/../uploads/" . $file["stored_name"];
            if (file_exists($old_file_path)) {
                unlink($old_file_path);
            }
            $delete_old_file_sql = "DELETE FROM files WHERE post_id = $id";
            mysqli_query($con, $delete_old_file_sql);
        }

        $file_insert_sql = "INSERT INTO files (post_id, original_name, stored_name) VALUES ($id, '$original_name', '$stored_name')";
        mysqli_query($con, $file_insert_sql);
    }
}

// 게시글 보기 페이지로 이동
header("Location: view.php?id=$id");
exit();
