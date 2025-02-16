<?php
include __DIR__ . "/../includes/db_connect.php";
include __DIR__ . "/../includes/session.php";

// GET 방식으로 전달된 글 번호(num) 가져오기
if (!isset($_GET["num"])) {
    die("잘못된 접근입니다.");
}

$num = $_GET["num"];

// 해당 게시글 조회
$sql = "SELECT f.num, u.username, f.subject, f.content, f.regist_day, f.user_id 
        FROM freeboard f
        JOIN users u ON f.user_id = u.id
        WHERE f.num = $num";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// 게시글이 존재하지 않으면 오류 출력
if (!$row) {
    die("해당 게시글이 존재하지 않습니다.");
}

// 로그인한 사용자가 작성자인지 확인
$is_owner = is_logged_in() && (get_user_id() == $row["user_id"]);

?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>게시글 보기</title>
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

        textarea {
            width: 100%;
            height: 150px;
            resize: none;
            border: none;
            background: none;
            font-size: 16px;
        }

        .button-container {
            text-align: center;
            margin-top: 15px;
        }

        .button-container form {
            display: inline-block;
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <fieldset>
        <legend>게시글 보기</legend>
        <table>
            <tr>
                <td><strong>제목:</strong></td>
                <td><?= htmlspecialchars($row["subject"]) ?></td>
            </tr>
            <tr>
                <td><strong>작성자:</strong></td>
                <td><?= htmlspecialchars($row["username"]) ?></td>
            </tr>
            <tr>
                <td><strong>작성일:</strong></td>
                <td><?= $row["regist_day"] ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea readonly><?= htmlspecialchars($row["content"]) ?></textarea>
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset>
        <legend>게시글 기능</legend>
        <div class="button-container">
            <form action="list.php" method="post">
                <button type="submit">목록으로</button>
            </form>

            <?php if ($is_owner): ?>
                <form action="modify_form.php" method="get">
                    <input type="hidden" name="num" value="<?= $num ?>">
                    <button type="submit">수정</button>
                </form>

                <form action="delete.php" method="post">
                    <input type="hidden" name="num" value="<?= $num ?>">
                    <button type="submit" onclick="return confirm('정말 삭제하시겠습니까?');">삭제</button>
                </form>
            <?php endif; ?>

            <form action="index.php" method="get">
                <button type="submit">홈으로</button> <!-- 홈으로 이동 버튼 추가 -->
            </form>
        </div>
    </fieldset>

</body>

</html>
