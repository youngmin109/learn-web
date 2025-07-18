<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>회원가입</title>
</head>
<body>

<h2>회원가입</h2>

<?php if (isset($_SESSION['error']))
    echo "<p style='color:red'>".htmlspecialchars($_SESSION['error'])."</p>";
    unset($_SESSION['error']);
?>

<form action="register_process.php" method="post">
    <fieldset>
        <legend>정보 입력</legend>

        <label for="username">아이디:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="name">이름:</label>
        <input type="text" id="name" name="name" required><br><br>

        <input type="submit" value="회원가입">
    </fieldset>
</form>

</body>
</html>
