<?php
include __DIR__ . "/../includes/session.php";

// 로그인하지 않은 경우 접근 차단
if (!is_logged_in()) {
    die("로그인 후 글을 작성할 수 있습니다.");
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>글쓰기</title>
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

    <fieldset>
        <legend>글쓰기</legend>
        <form action="insert.php" method="post">
            <table>
                <tr>
                    <td><label>제목:</label></td>
                    <td><input type="text" name="subject" required></td>
                </tr>
                <tr>
                    <td><label>내용:</label></td>
                    <td><textarea name="content" rows="5" required></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <button type="submit">등록</button>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>

</body>
</html>
