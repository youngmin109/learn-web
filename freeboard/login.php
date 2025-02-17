<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $con = mysqli_connect("localhost", "user", "12345", "user");

    // 사용자 조회
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    // 로그인 검증
    if ($row && password_verify($password, $row["password"])) {
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
        header("Location: list.php");
        exit();
    } else {
        echo "아이디 또는 비밀번호가 올바르지 않습니다.";
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
</head>

<body>
    <fieldset style="display: inline-block; padding: 15px; border-radius: 10px;">
        <legend>로그인</legend>
        <form method="post">
            <table>
                <tr>
                    <td><label for="username">아이디:</label></td>
                    <td><input type="text" id="username" name="username" required></td>
                </tr>
                <tr>
                    <td><label for="password">비밀번호:</label></td>
                    <td><input type="password" id="password" name="password" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center; padding-top: 10px;">
                        <button type="submit">로그인</button>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>

</body>

</html>