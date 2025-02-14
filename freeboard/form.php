<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>글쓰기</title>
</head>
<body>
    <h2>자유 게시판 > 글쓰기</h2>

    <form name="board" method="post" action="insert.php">
        <fieldset>
            <legend>작성자 정보</legend>
            <label>이름:</label>
            <input name="name" type="text" required>
            
            <label>비밀번호:</label>
            <input name="pass" type="password" required>
        </fieldset>

        <fieldset>
            <legend>글 내용</legend>
            <label>제목:</label>
            <input name="subject" type="text" required>

            <label>내용:</label>
            <textarea name="content" required></textarea>
        </fieldset>

        <button type="submit">저장하기</button>
        <button type="button" onclick="location.href='list.php'">목록보기</button>
    </form>
</body>
</html>