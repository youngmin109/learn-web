<?php
include __DIR__ . "/../includes/db_connect.php";
include __DIR__ . "/../includes/session.php";

// 게시글 목록 가져오기 (최신순)
$sql = "SELECT f.num, u.username, f.subject, f.regist_day 
        FROM freeboard f 
        JOIN users u ON f.user_id = u.id
        ORDER BY f.num DESC";
// 8번에서 두 테이블의 칼럼을 연결
// SELECT를 두번 쓸 필요 없이
// JOIN은 여러 테이블을 합쳐서 조회. 
// 앞에 접두어는 구별하는 역할 

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>게시판 목록</title>
    <style>
        fieldset {
            width: 800px;
            margin: 20px auto;
            padding: 15px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f8f8f8;
        }
    </style>
</head>

<body>

    <fieldset>
        <legend>게시판 목록</legend>
        <table>
            <thead>
                <tr>
                    <th width="10%">번호</th>
                    <th width="50%">제목</th>
                    <th width="20%">글쓴이</th>
                    <th width="20%">등록일</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row["num"] ?></td>
                        <td><a href="view.php?num=<?= $row["num"] ?>"><?= htmlspecialchars($row["subject"]) ?></a></td>
                        <td><?= htmlspecialchars($row["username"]) ?></td>
                        <td><?= $row["regist_day"] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </fieldset>

    <fieldset>
        <legend>게시판 기능</legend>
        <div style="text-align: center;">
            <?php if (is_logged_in()): ?>
                <div style="display: inline-block; margin-right: 10px;">
                    <form action="form.php" method="post">
                        <button type="submit">글쓰기</button>
                    </form>
                </div>
                <div style="display: inline-block; margin-right: 10px;">
                    <form action="logout.php" method="post">
                        <button type="submit">로그아웃</button>
                    </form>
                </div>
            <?php else: ?>
                <p>글을 작성하려면 로그인하세요.</p>
            <?php endif; ?>
            <div style="display: inline-block;">
                <form action="index.php" method="get">
                    <button type="submit">홈으로</button>
                </form>
            </div>
        </div>
    </fieldset>


</body>

</html>