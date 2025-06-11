<?php
session_start();

// 데이터베이스 연결
$con = mysqli_connect("localhost", "user", "12345", "user");

// 게시글과 회원 정보를 `JOIN`하여 조회 (최신순 정렬)
$sql = "SELECT freeboard.num, freeboard.subject, users.username, freeboard.regist_day 
        FROM freeboard 
        JOIN users ON freeboard.user_id = users.id 
        ORDER BY freeboard.num DESC";
$result = mysqli_query($con, $sql);
$total_record = mysqli_num_rows($result); // 전체 글 수

// DB 연결 종료
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="ko">
<head> 
    <meta charset="utf-8">
    <title>게시판 목록</title>
</head>
<body> 
    <h2>자유 게시판 > 목록보기</h2>

    <fieldset>
        <legend>게시글 목록</legend>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th width="10%">번호</th>
                    <th width="50%">제목</th>
                    <th width="20%">글쓴이</th>
                    <th width="20%">등록일</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $number = $total_record; // 글 번호 매김
                while ($row = mysqli_fetch_assoc($result)) {
                    $num = $row["num"];
                    $subject = htmlspecialchars($row["subject"]);
                    $username = htmlspecialchars($row["username"]); // users 테이블의 username
                    $regist_day = $row["regist_day"];
                ?>
                <tr>
                    <td align="center"><?= $number ?></td>
                    <td><a href="view.php?num=<?= $num ?>"><?= $subject ?></a></td>
                    <td align="center"><?= $username ?></td>
                    <td align="center"><?= $regist_day ?></td>
                </tr>
                <?php
                    $number--;
                }
                ?>
            </tbody>
        </table>
    </fieldset>

    <fieldset>
        <legend>게시판 기능</legend>
        
        <?php if (isset($_SESSION["user_id"])) { ?>
            <p>안녕하세요, <?= $_SESSION["username"] ?>님!</p>
            <form action="form.php" method="post">
                <button type="submit">글쓰기</button>
            </form>
            <form action="logout.php" method="post">
                <button type="submit">로그아웃</button>
            </form>
        <?php } else { ?>
            <p><a href="login.php">로그인</a> 후 글을 작성할 수 있습니다.</p>
            <p>아직 회원이 아니라면? <a href="register.php">회원가입</a></p>
        <?php } ?>

    </fieldset>
</body>
<!-- 수정 25.03.01!--> 
</html>
