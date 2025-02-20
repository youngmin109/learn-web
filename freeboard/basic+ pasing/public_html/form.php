<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>글 작성</title>
</head>
<body>
    <h2>글 작성</h2>

    <form action="insert.php" method="post">
        <fieldset>
            <legend>새 글 작성</legend>
            <table>
                <tr>
                    <td><label for="name">이름:</label></td>
                    <td><input type="text" id="name" name="name" required></td>
                </tr>
                <tr>
                    <td><label for="password">비밀번호:</label></td>
                    <td><input type="password" id="password" name="password" required></td>
                </tr>
                <tr>
                    <td><label for="subject">제목:</label></td>
                    <td><input type="text" id="subject" name="subject" required></td>
                </tr>
                <tr>
                    <td><label for="content">내용:</label></td>
                    <td><textarea id="content" name="content" rows="5" required></textarea></td>
                </tr>
            </table>
            <button type="submit">등록</button>
            <button type="button"><a href="index.php"></a>목록으로</button>
        </fieldset>
    </form>
</body>
</html>
