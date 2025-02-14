<?php
$mode = isset($_POST["mode"]) ? $_POST["mode"] : "";
$num = isset($_POST["num"]) ? $_POST["num"] : "";
$error = isset($_GET["error"]) ? $_GET["error"] : "";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>비밀번호 확인</title>
</head>
<body>
    <h2>게시글 수정/삭제</h2>
    
    <fieldset>
        <legend>비밀번호 입력</legend>
        <?php if ($error == "y") { ?>
            <p style="color:red;">비밀번호가 틀립니다. 다시 입력해주세요!</p>
        <?php } ?>
        
        <form action="password.php" method="post">
            <input type="hidden" name="mode" value="<?= $mode ?>">
            <input type="hidden" name="num" value="<?= $num ?>">
            <label>비밀번호:</label>
            <input type="password" name="pass" required>
            <button type="submit">확인</button>
        </form>
    </fieldset>
</body>
</html>
