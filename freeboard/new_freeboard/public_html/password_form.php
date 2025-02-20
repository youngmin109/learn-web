<?php
include __DIR__ . "/../includes/session.php";

// GET 요청에서 게시글 번호(num) 가져오기
if (!isset($_GET["num"])) {
    die("잘못된 접근입니다.");
}

$num = $_GET["num"];
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 삭제</title>
    <style>
        fieldset {
            width: 400px;
            margin: auto;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 5px;
            margin-top: 10px;
        }

        .button-container {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
    </style>
</head>

<body>
    <fieldset>
        <legend>게시글 삭제</legend>
        <p>게시글을 삭제하려면 비밀번호를 입력하세요.</p>

        <!-- 비밀번호 입력 폼 -->
        <form action="delete.php" method="post">
            <input type="hidden" name="num" value="<?= $num ?>"> <!-- 삭제할 게시글 번호 -->
            <label for="password">비밀번호:</label>
            <input type="password" name="password" id="password" required>
            
            <div class="button-container">
                <button type="submit">삭제하기</button>
                <a href="view.php?num=<?= $num ?>"><button type="button">취소</button></a>
            </div>
        </form>
    </fieldset>
</body>

</html>
