<?php
include __DIR__ . "/../includes/db_connect.php";  // DB 연결

// 게시글 목록 가져오기 (최신순 정렬)
$sql = "SELECT * FROM freeboard ORDER BY id DESC" ;
$result = mysqli_query($con, $sql);

?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>게시판 목록</title>
</head>

<body>
    <h2>게시판 목록</h2>

    <!-- 게시글 목록 출력 -->
    <table border="1">
        <thead> <!-- 헤더 콘텐츠들을 하나의 그룹으로 묶을 때 사용-->
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>작성일</th>
            </tr>
        </thead>
        <tbody> <!-- 하나의 그룹으로 묶음 -->
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><a href="view.php?id=<?= $row["id"] ?>"><?= htmlspecialchars($row["subject"]) ?></a></td>
                    <td?><?= htmlspecialchars($row["name"]) ?></td>
                    <td><?= $row["created_at"] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- 글쓰기 버튼 -->
    <form action="form.php" method="get">
        <button>글쓰기</button>
    </form>
</body>

</html>