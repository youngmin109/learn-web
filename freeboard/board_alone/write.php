<?php
// 세션 에러 출력
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>게시글 작성</h2>
    <form action="write_process.php" method="post">
        <fieldset>
            <!-- 작성자 이름 입력 -->
            <label for="name">작성자 이름</label>
            <input type="text" id="name" name="name" required><br><br>

            <!-- 비밀번호 입력 -->
            <label for="password">비밀번호</label>
            <input type="password" id="password" name="password" required><br><br>

            <!-- 제목 입력 -->
            <label for="title">제목</label>
            <input type="text" id="title" name="title" required><br><br>

            <!-- 내용 입력 -->
            <label for="content">내용</label>
            <textarea id="content" name="content" required></textarea><br><br>

            <!-- 등록 버튼 -->
            <input type="submit" value="등록하기">
        </fieldset>
    </form>
</body>

</html>