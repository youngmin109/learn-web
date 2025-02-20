<?php
include __DIR__ . "/../includes/db_connect.php";
include __DIR__ . "/../includes/session.php";

if (!is_logged_in()) {
    die("로그인이 필요합니다. <a href='login.php'>로그인</a>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = get_user_id();
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // 새 비밀번호 확인
    if ($new_password !== $confirm_password) {
        die("새 비밀번호가 일치하지 않습니다.");
    }

    // 현재 비밀번호 확인
    $sql = "SELECT password FROM users WHERE id = $user_id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row || !password_verify($current_password, $row["password"])) {
        die("현재 비밀번호가 틀렸습니다.");
    }

    // 새 비밀번호 저장 (암호화)
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = '$hashed_password' WHERE id = $user_id";
    mysqli_query($con, $sql);

    echo "비밀번호가 성공적으로 변경되었습니다. <a href='list.php'>게시판으로 이동</a>";
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>비밀번호 변경</title>
</head>
<body>
    <fieldset style="width: 400px; margin: auto; padding: 15px; border-radius: 10px;">
        <legend>비밀번호 변경</legend>
        <form method="post">
            <table>
                <tr>
                    <td><label for="current_password">현재 비밀번호:</label></td>
                    <td><input type="password" id="current_password" name="current_password" required></td>
                </tr>
                <tr>
                    <td><label for="new_password">새 비밀번호:</label></td>
                    <td><input type="password" id="new_password" name="new_password" required></td>
                </tr>
                <tr>
                    <td><label for="confirm_password">새 비밀번호 확인:</label></td>
                    <td><input type="password" id="confirm_password" name="confirm_password" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <button type="submit">변경하기</button>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</body>
</html>
