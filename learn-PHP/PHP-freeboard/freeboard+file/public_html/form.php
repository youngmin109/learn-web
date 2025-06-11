<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>게시글 작성</title>
</head>

<body>
    <h2>게시글 작성</h2>
    <form action="insert.php" method="post" enctype="multipart/form-data">
    <!-- 파일 업로드를 가능하게함 text / file(바이너리) 따로 전송 
     enctype = form 태그에서 데이터를 서버로 전송하는 방식을 정의하는 속성-->
        <table border="1">
            <tr>
                <td><label for="title">제목</label></td>
                <td><input type="text" name="title" id="title" required></td>
            </tr>
            <tr>
                <td><label for="author">작성자</label></td>
                <td><input type="text" name="author" id="author" required></td>
            </tr>
            <tr>
                <td><label for="password">비밀번호</label></td>
                <td><input type="password" name="password" id="password" required></td>
            </tr>
            <tr>
                <td><label for="content">내용</label></td>
                <td><textarea name="content" id="content" rows="5" required></textarea></td>
            </tr>
            <tr>
                <td><label for="file">파일 첨부</label></td>
                <td><input type="file" name="file" id="file"></td>
            </tr>
        </table>
        <button type="submit">등록</button>
        <button type="button" onclick="location.href='index.php'">취소</button>
    </form>
</body>

</html>
