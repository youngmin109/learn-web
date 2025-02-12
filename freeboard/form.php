<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PHP 게시판</title>
</head>
<body>
    <h2>자유 게시판 > 글쓰기</h2>
    <form name="board" method="post" action="insert.php">
        <ul>
            <li>
                <label>이름:</label>
                <input name="name" type="text" required>
            </li>
            <li>
                <label>비밀번호:</label>
                <input name="pass" type="password" required>
            </li>
            <li>
                <label>제목:</label>
                <input name="subject" type="text" required>
            </li>
            <li>
                <label>내용:</label>
                <textarea name="content" required></textarea>
            </li>
        </ul>
        <button type="submit">저장하기</button>
        <button type="button" onclick="location.href='list.php'">목록보기</button>
    </form>
</body>
</html>
