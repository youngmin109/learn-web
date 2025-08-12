<?php
require_once 'init.php';

$id = $_GET['id'];

try {
$mysqli = db_con();

$sql = "SELECT * FROM posts WHERE id=$id";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

$name = $row['name'];
$title = $row['title'];
$content = $row['content'];
} catch (Exception) {
    fail('데이터 베이스 오류');
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 수정</title>
</head>

<body>
    <h2>게시글 수정</h2>
    <form action="./edit_process.php" method="POST">
        <fieldset>
            <input type="hidden" name="id" value="<?php echo $row['id']?>">
            작성자 이름: <input type="text" name="name" value="<?php echo $name ?>"><br><br>
            비밀번호: <input type="password" name="password"><br><br>
            제목: <input type="text" name="title" value="<?php echo $title ?>"><br><br>
            내용: <input type="text" name="content" value="<?php echo $content ?>"><br><br>
            <button>수정하기</button>
            <button><a href="./view.php?id=<?php echo $id ?>">취소하기</a></button>
        </fieldset>
    </form>
</body>
</html>