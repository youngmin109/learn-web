<?php
include __DIR__ . "/../includes/db_connect.php"; // DB 연결

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $subject = $_POST["subject"];
    $content = $_POST["content"];

    // 기존 게시글의 비밀번호 확인
    $sql = "SELECT password FROM freeboard WHERE id = $id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        die("해당 게시글이 존재하지 않습니다.");
    }

    if ($password !== $row["password"]) {
        die("비밀번호가 일치하지 않습니다.");
    }

    // 비밀번호가 일치하면 업데이트 실행
    $sql = "UPDATE freeboard SET name='$name', subject='$subject', content='$content' WHERE id=$id";
    if (mysqli_query($con, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "게시글 수정 실패: " . mysqli_error($con);
    }
}
?>
