<?php
include __DIR__ . "/../includes/db_connect.php";
include __DIR__ . "/../includes/session.php";

// `POST` 방식으로 전달된 값 확인 (직접 URL 접근 차단)
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("잘못된 접근입니다.");
}
// 삭제는 반드시 POST 요청 해서 직접 URL을 입력해서 삭제하는 것을 방지지
// 삭제할 글 번호 가져오기
// num값이 정상적으로 전달되었는가?
if (!isset($_POST["num"])) {
    die("삭제할 글이 없습니다.");
}

$num = $_POST["num"];

// 해당 글이 로그인한 사용자의 글인지 확인
$sql = "SELECT user_id FROM freeboard WHERE num = $num";
$result = mysqli_query($con, $sql); // 연결정보와 실행할 SQL문
$row = mysqli_fetch_assoc($result); // 쿼리 결과에서 한 레코드를 가져오는 함수
// 연관 배열로 변환 ($row은 "user_id => 작성자의 id) 

// 만약 row가 null이면 글존재X
// 현재 로그인한 사용자의 아이디와 삭제하려는 글의 id가 일치하지 않을 때 차단
if (!$row || get_user_id() != $row["user_id"]) {
    die("삭제 권한이 없습니다.");
}

// if (!$row) {
//     die("해당 게시글을 찾을 수 없습니다.");
// }

// // 비밀번호 검증
// if (!password_verify($password, $row["password"])) {
//     die("비밀번호가 일치하지 않습니다.");
// }

// 해당 글 삭제
$sql = "DELETE FROM freeboard WHERE num = $num";
mysqli_query($con, $sql);

// 삭제 후 목록 페이지로 이동
header("Location: list.php");
exit();
?>
