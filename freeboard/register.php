<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // 비밀번호 해시화
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 데이터베이스 연결
    $con = mysqli_connect("localhost", "user", "12345", "user");

    // 연결 오류 확인
    if (!$con) {
        die("MySQL 연결 실패: " . mysqli_connect_error());
    }

    // SQL 인젝션 방지
    $username = mysqli_real_escape_string($con, $username);
    $hashed_password = mysqli_real_escape_string($con, $hashed_password);

    // 아이디 중복 확인
    $check_sql = "SELECT * FROM users WHERE username='$username'";
    $check_result = mysqli_query($con, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // 중복 아이디 에러 메시지를 표시하고 회원가입 페이지로 다시 이동
        header("Location: register.php?error=1");
        exit();
    }

    // 회원가입 실행
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
    if (mysqli_query($con, $sql)) {
        // 회원가입 성공 시 로그인 페이지로 이동
        header("Location: login.php");
        exit();
    } else {
        echo "회원가입 실패: " . mysqli_error($con);
        exit();
    }

    // 데이터베이스 연결 종료
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 회원가입</title>
</head>

<body>
    <fieldset style="display: inline-block; padding: 15px; border-radius: 10px;">
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
                    <td colspan="2" style="text-align: center; padding-top: 10px;">
                        <button type="submit">가입하기</button>
                    </td>
                </tr>
            </table>
        </form>

        <?php
        // 중복 아이디 에러 메시지 표시
        if (isset($_GET["error"]) && $_GET["error"] == "1") {
            echo "<p style='color: red; text-align: center;'>이미 사용 중인 아이디입니다.</p>";
        }
        ?>
    </fieldset>
</body>
</html>
