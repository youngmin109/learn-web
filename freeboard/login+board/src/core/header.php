<?php
// 위에 헤더 페이지, 불러와서 사용
$user = $_SESSION['username'] ?? null;

echo "<a href='./index.php'>게시판</a> | ";
if ($user) {
    echo "<a href='./write.php'>글쓰기</a> | ";
    echo "<a href='./logout.php'>로그아웃</a>";
} else {
    echo "<a href='./login.php'>로그인</a>";
}
?>