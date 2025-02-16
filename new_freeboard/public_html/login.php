<?php
include __DIR__ . "/../includes/db_connect.php"; // 올바른 경로 설정
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row["password"])) {
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
        header("Location: list.php");
        exit();
    } else {
        echo "로그인 실패: 아이디 또는 비밀번호가 틀립니다.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>로그인</title>
    <style>
        fieldset {
            width: 350px; /* 로그인 창 크기에 맞추기 */
            margin: 50px auto; /* 가운데 정렬 */
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
        <legend>로그인</legend>
        <form method="post">
            <table>
                <tr>
                    <td><label>아이디:</label></td>
                    <td><input type="text" name="username" required></td>
                </tr>
                <tr>
                    <td><label>비밀번호:</label></td>
                    <td><input type="password" name="password" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <button type="submit">로그인</button>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</body>
</html>
