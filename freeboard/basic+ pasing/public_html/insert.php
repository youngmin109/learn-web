<?php
include __DIR__ . "/../includes/db_connect.php";

// POST 요청인지 확인
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];
    $subject = $_POST["subject"];
    $content = $_POST["content"];

    // 현재 시간 추가 (한국 시간 기준)
    date_default_timezone_set("Asia/Seoul");
    $created_at = date("Y-m-d H:i:s");

    // 데이터 삽입 쿼리 실행
    $sql = "INSERT INTO freeboard (name, password, subject, content, created_at)
        VALUES ('$name', '$password', '$subject', '$content', '$created_at')";
    
    echo $sql;
    if (mysqli_query($con, $sql)) { //쿼리를 실행하는 함수, 성공하면 TRUE반환 
        // 등록되면 index로 이동
        echo "게시글이 성공적으로 등록되었습니다.0";
        header("refresh:2; url=index.php"); // 2초 후 이동
        exit();
    } else {
        echo "게시글 등록 실패: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
