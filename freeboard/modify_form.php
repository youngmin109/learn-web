<?php

// **한국 시간(KST)으로 설정**
date_default_timezone_set("Asia/Seoul");

// URL에서 num 가져오기
if (isset($_GET["num"])) {
    $num = $_GET["num"];
} else {
    die("잘못된 접근 입니다.");
}

$con = mysqli_connect("localhost", "user", "12345", "user");

// 게시글 정보 가져오기
$sql = "SELECT * FROM freeboard WHERE num=$num";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// 게시글이 존재하지 않으면 종료
if (!$row) {
    die("해당 게시글을 찾을 수 없습니다.");
}

// 가져온 데이터를 변수에 저장
$name = $row["name"];
$subject = $row["subject"];
$content = $row["content"];
$pass = $row["pass"];
$regist_day = date("Y-m-d (H:i)"); // UTC 기준 현재 날짜

// 데이터베이스 연결 종료
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 수정</title>
</head>
<body>
    <h2>자유 게시판 > 글 수정하기</h2>
    
    <fieldset>
    <form method="post" action="modify.php">
        <input type="hidden" name="num" value="<?= $num ?>">

        <label>이름:</label>
        <input name="name" type="text" value="<?= htmlspecialchars($name) ?>" required>

        <label>비밀번호:</label>
        <input name="pass" type="password" required><br>
        </fieldset>

        <fieldset>
        <label>제목:</label>
        <input name="subject" type="text" value="<?= htmlspecialchars($subject) ?>" required>

        <label>내용:</label>
        <textarea name="content" required><?= htmlspecialchars($content) ?></textarea>
        </fieldset>

        <button type="submit">저장하기</button>
        <button type="button" onclick="window.location.href='list.php'">목록보기</button>
    </form>
</body>
</html>