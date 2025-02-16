<?php
include __DIR__ . "/../includes/db_connect.php";
include __DIR__ . "/../includes/session.php"; // 로그인 세션 사용

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // 아이디 중복 확인
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        die("이미 존재하는 아이디입니다.");
    }

    // 비밀번호 암호화 후 저장
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
    mysqli_query($con, $sql);

    // 자동 로그인 처리 (회원가입 후 바로 로그인)
    $user_id = mysqli_insert_id($con); // 방금 가입한 사용자 ID 가져오기
    $_SESSION["user_id"] = $user_id;
    $_SESSION["username"] = $username;

    header("Location: list.php"); // 게시판으로 이동
    exit();
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>회원가입</title>
</head>
<body>
    <fieldset style="width: 400px; margin: auto; padding: 15px; border-radius: 10px;">
        <legend>회원가입</legend>
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
                    <td colspan="2" style="text-align: center;">
                        <button type="submit">가입하기</button>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</body>
</html>
