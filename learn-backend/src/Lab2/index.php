<?php

if (isset($_COOKIE['username'])) {
    $username = htmlspecialchars($_COOKIE['username']);

    echo "{$username}님의 주문 내용<br>
    <ul>
    <li>라떼: {$_COOKIE['latte']}</li>
    <li>아아: {$_COOKIE['americano']}</li>
    </ul>";
    echo "<a href='./edit_order.php'>주문 수정</a><br>";
    echo "<a href='./delete_cookie.php'>주문 초기화</a>";
} else { echo "<form action='./set_cookie.php' method='post'>
    이름:<input type='text' name='username' value=><br>
    라떼 수량: <input type='text' name='latte'><br>
    아아 수량: <input type='text' name='americano'><br>
    <button type='submit'>주문하기</button>
</form>";
}
?>