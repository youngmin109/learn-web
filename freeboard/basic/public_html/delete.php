<?php
include __DIR__ . "/../includes/db_connect.php";  // DB 연결

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $password = $_POST["password"];

    // 해당 게시글의 비밀번호 확인
    $sql = "SELECT password FROM freeboard WHERE id = $id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        die("해당 게시글이 존재하지 않습니다.");
    }

    if ($password !== $row["password"]) {
        die("비밀번호가 일치하지 않습니다.");
    }

    // 비밀번호가 일치하면 삭제 진행
    $delete_sql = "DELETE FROM freeboard WHERE id = $id";
    if (mysqli_query($con, $delete_sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "게시글 삭제 실패: " . mysqli_error($con);
    }
}
?>