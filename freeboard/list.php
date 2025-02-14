<?php
// 데이터베이스 연결
$con = mysqli_connect("localhost", "user", "12345", "user");

// 전체 게시글 조회 (최신순)
$sql = "SELECT * FROM freeboard ORDER BY num DESC";
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
                    $name = htmlspecialchars($row["name"]);
                    $subject = htmlspecialchars($row["subject"]);
                    $regist_day = $row["regist_day"];
                ?>
                <tr>
                    <td align="center"><?= $number ?></td>
                    <td><a href="view.php?num=<?= $num ?>"><?= $subject ?></a></td>
                    <td align="center"><?= $name ?></td>
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
        <form action="form.php" method="post">
            <button type="submit">글쓰기</button>
        </form>
    </fieldset>
</body>
</html>