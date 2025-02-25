<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시글 작성</title>
</head>
<body>
    <h2>게시글 작성</h2>
    <form action="insert.php" method="post" enctype="multipart/form-data">
        <label>이름: <input type="text" name="name" required></label><br>
        <label>비밀번호: <input type="password" name="password" required></label><br>
        <label>제목: <input type="text" name="subject" required></label><br>
        <label>내용: <textarea name="content" required></textarea></label><br>
        <label>파일 업로드: <input type="file" name="upload_file"></label><br>
        <button type="submit">등록</button>
    </form>
</body>
</html>
