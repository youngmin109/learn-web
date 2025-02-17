<?php
// GET 요청으로 게시글 번호(num) 가져오기
if (!isset($_GET["num"])) {
    die("잘못된 접근입니다.");
}
$num = $_GET["num"];

// 데이터베이스 연결
$con = mysqli_connect("localhost", "user", "12345", "user");

// 특정 게시글 검색
$sql = "SELECT * FROM freeboard WHERE num=$num";
$result = mysqli_query($con, $sql);

// 게시글이 존재하는지 확인
$row = mysqli_fetch_assoc($result);
if (!$row) {
    die("해당 게시글을 찾을 수 없습니다.");
}

// 가져온 데이터 저장
$name = $row["name"];            // 이름
$subject = $row["subject"];      // 제목
$regist_day = $row["regist_day"]; // 작성일
$content = $row["content"];      // 내용

// 공백 및 줄바꿈 변환
$content = str_replace(" ", "&nbsp;", $content);
$content = nl2br($content);  // 줄바꿈을 <br>로 변환

// DB 연결 종료
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="ko">
<head> 
    <meta charset="utf-8">
    <title>게시글 보기</title>
</head>
<body> 
    <h2>자유 게시판 > 내용보기</h2>

    <fieldset>
        <legend>게시글 정보</legend>
        <p><strong>제목:</strong> <?= htmlspecialchars($subject) ?></p>
        <p><strong>작성자:</strong> <?= htmlspecialchars($name) ?> | <?= $regist_day ?></p>
    </fieldset>

    <fieldset>
        <legend>게시글 내용</legend>
        <p><?= $content ?></p>
    </fieldset>

    <form method="post" action="list.php">
        <button type="submit">목록보기</button>
    </form>

    <form method="post" action="password_form.php">
        <input type="hidden" name="num" value="<?= $num ?>">
        <input type="hidden" name="mode" value="modify">
        <button type="submit">수정하기</button>
    </form>

    <form method="post" action="password_form.php">
        <input type="hidden" name="num" value="<?= $num ?>">
        <input type="hidden" name="mode" value="delete">
        <button type="submit">삭제하기</button>
    </form>

    <form method="post" action="form.php">
        <button type="submit">글쓰기</button>
    </form>
</body>
</html>
