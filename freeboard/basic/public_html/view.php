<?php
include __DIR__ . "/../includes/db_connect.php";

// GET 요청으로 게시글 ID 가져오기 
if (!isset($_GET["id"])) {
    die("잘못된 접근");
}

// GET으로 받은 'id' 값을 저장
$id = $_GET["id"];

// 게시글 데이터 가져오기
$sql = "SELECT * FROM freeboard WHERE id = $id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// 게시글이 존재하지 않으면 오류 출력
if (!$row) {
    die("해당 게시글이 존재하지 않습니다.");
}

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>게시글 보기</title>
</head>

<body>
    <h2>게시글 보기</h2>

    <fieldset style="width: 600px; margin: auto; padding: 15px; border-radius: 10px;">
        <legend>게시글 정보</legend>
        <table border="1" width="100%">
            <tr>
                <th>번호</th>
                <td><?= $row["id"] ?></td>
            </tr>
            <tr>
                <th>제목</th>
                <td><?= htmlspecialchars($row["subject"]) ?></td>
            </tr>
            <tr>
                <th>작성자</th>
                <td><?= htmlspecialchars($row["name"]) ?></td>
            </tr>
            <tr>
                <th>작성일</th>
                <td><?= $row["created_at"] ?></td>
            </tr>
            <tr>
                <th>내용</th>
                <td>
                    <pre><?= htmlspecialchars($row["content"]) ?></pre>
                </td>
            </tr>
        </table>
    </fieldset>

    <form action="modify_form.php" method="get">
        <input type="hidden" name="id" value="<?= $row["id"] ?>">
        <button>수정</button>
    </form>

    <form action="delete.php" method="post" style="display:inline;">
        <input type="hidden" name="id" value="<?= $row["id"] ?>">
        <label>비밀번호:</label>
        <input type="password" name="password" required> 
        <button type="submit">삭제</button>
    </form>

    <!-- 목록으로 돌아가기 -->
    <form action="index.php" method="get">
        <button type="submit">목록으로</button>
    </form>

</body>

</html>