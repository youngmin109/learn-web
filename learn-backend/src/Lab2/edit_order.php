<?php
echo '<h1>주문 수정</h1>';
echo '<form action="./update_cookie.php" method="post">';
echo '<input type="text" name="username"  value="' . htmlspecialchars($_COOKIE['username']) . '"><br>';
echo '<input type="text" name="latte"     value="' . htmlspecialchars($_COOKIE['latte']) . '"><br>';
echo '<input type="text" name="americano" value="' . htmlspecialchars($_COOKIE['americano']) . '"><br>';
echo '<button type="submit">수정 완료</button>';
echo '</form>';