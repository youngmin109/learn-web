<?php
include __DIR__ . "/../includes/db_connect.php";
include __DIR__ . "/../includes/session.php";

// GET 방식으로 글 번호(num) 가져오기
if (!isset($_GET["num"])) {
    die("잘못된 접근입니다.");
}

$num = $_GET["num"];

// 해당 글 조회
$sql = "SELECT * FROM freeboard WHERE num = $num";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// 게시글이 존재하지 않으면 오류 출력
if (!$row) {
    die("해당 게시글이 존재하지 않습니다.");
}

// 본인이 작성한 글인지 확인
if (!is_logged_in() || get_user_id() != $row["user_id"]) {
    die("수정 권한이 없습니다.");
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>글 수정</title>
    <style>
        fieldset {
            width: 600px;
            margin: 20px auto;
            padding: 15px;
            border-radius: 10px;
        }
        table {
            width: 100%;
        }
    </style>
</head>
<body>

<form action="index.php" method="get">
    <button type="submit">홈으로</button> <!-- 인덱스로 이동하는 버튼 추가 -->
</form>
    <fieldset>
        <legend>글 수정</legend>
        <form action="modify.php" method="post">
            <input type="hidden" name="num" value="<?= $num ?>">
            <table>
                <tr>
                    <td><label>제목:</label></td>
                    <td><input type="text" name="subject" value="<?= htmlspecialchars($row["subject"]) ?>" required></td>
                </tr>
                <tr>
                    <td><label>내용:</label></td>
                    <td><textarea name="content" rows="5" required><?= htmlspecialchars($row["content"]) ?></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <button type="submit">수정하기</button>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>

</body>
</html>
