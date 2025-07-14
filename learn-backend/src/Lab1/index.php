<?php
// cookie
if (isset($_COOKIE['username'])) {
    $username = htmlspecialchars($_COOKIE['username']);
    echo "안녕하세요, {$username}님!<br>";
    echo "<a href='delete_cookie.php'>쿠키 삭제</a>";
} else {
    echo "<form method='POST' action='set_cookie.php'>
        이름: <input type='text' name='username'>
        <button type='submit'>저장</button>
        </form>";
}
?>
