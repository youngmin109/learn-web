<?php
include __DIR__ . "/../includes/db_connect.php";  // DB 연결

// 게시글 ID 확인
if (!isset($_GET["id"])) {
    die("잘못된 접근입니다.");
}

$id = (int)$_GET["id"];

// 게시글 가져오기
$sql = "SELECT * FROM freeboard WHERE id = $id";
$result = mysqli_query($con, $sql);
$post = mysqli_fetch_assoc($result);

// 게시글 존재 여부 확인
if (!$post) {
    die("게시글이 존재하지 않습니다.");
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>게시글 수정</title>
</head>

<body>
    <h2>게시글 수정</h2>
    <form action="modify.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id ?>">
        <table border="1">
            <tr>
                <td><label for="title">제목</label></td>
                <td><input type="text" name="title" id="title" value="<?= htmlspecialchars($post["title"]) ?>" required></td>
            </tr>
            <tr>
                <td><label for="author">작성자</label></td>
                <td><input type="text" name="author" id="author" value="<?= htmlspecialchars($post["author"]) ?>" required></td>
            </tr>
            <tr>
                <td><label for="password">비밀번호</label></td>
                <td><input type="password" name="password" id="password" required></td>
            </tr>
            <tr>
                <td><label for="content">내용</label></td>
                <td><textarea name="content" id="content" rows="5" required><?= htmlspecialchars($post["content"]) ?></textarea></td>
            </tr>
            <tr>
                <td><label for="file">첨부파일</label></td>
                <td>
                    <input type="file" name="file" id="file">
                    <?php
                    // 기존 파일 가져오기
                    $file_sql = "SELECT * FROM files WHERE post_id = $id";
                    $file_result = mysqli_query($con, $file_sql);
                    $file = mysqli_fetch_assoc($file_result);

                    if ($file) :
                    ?>
                        <p>현재 파일: <a href="download.php?file=<?= $file["stored_name"] ?>"><?= $file["original_name"] ?></a></p>
                        <input type="checkbox" name="delete_file" value="1"> 파일 삭제
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        <button type="submit">수정</button>
        <button type="button" onclick="location.href='view.php?id=<?= $id ?>'">취소</button>
    </form>
</body>

</html>
