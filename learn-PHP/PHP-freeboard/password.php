<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("잘못된 접근입니다.");
}

$mode = $_POST["mode"];  // modify 또는 delete 값 받음
$num = $_POST["num"];
$pass = $_POST["pass"];

// 데이터베이스 연결
$con = mysqli_connect("localhost", "user", "12345", "user");

// 특정 게시글의 비밀번호 가져오기
$sql = "SELECT pass FROM freeboard WHERE num=$num";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$db_password = $row["pass"];

// 연결 종료
mysqli_close($con);

// 사용자가 입력한 비밀번호가 DB에 저장된 비밀번호와 같은지 확인
if ($pass == $db_password) {
    if ($mode == "modify") {
        // 수정 폼으로 이동
        header("Location: modify_form.php?num=$num");
        exit();
    } else if ($mode == "delete") {
        // 삭제 페이지로 `POST` 데이터 전달
?>
        <form id="deleteForm" method="post" action="delete.php">
            <input type="hidden" name="num" value="<?= $num ?>">
            <button type="submit">삭제하기</button>
        </form>
<?php
        exit();
    }
} else {
    // 비밀번호가 틀리면 다시 비밀번호 입력 폼으로 이동
    header("Location: password_form.php?num=$num&error=y");
    exit();
}
?>
