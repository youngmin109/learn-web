<?php
include __DIR__ . "/../includes/db.connect.php";

// 검색 조건 설정
$search_type = isset($_GET["search_type"]) ? $_GET["search_type"] : "";
$search_keyword = isset($_GET["search_keyword"]) ? $_GET["search_keyword"] : "";

// 현재 페이지 설정 (GET으로 받고, 없으면 1페이지)
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// 🔹 WHERE 조건을 동적으로 생성
$where_clause = "";
if (!empty($search_keyword)) {
    $search_keyword = mysqli_real_escape_string($con, $search_keyword);
    $where_conditions = [];

    if ($search_type == "title") {
        $where_conditions[] = "title LIKE '%$search_keyword%'";
    } elseif ($search_type == "content") {
        $where_conditions[] = "content LIKE '%$search_keyword%'";
    } elseif ($search_type == "title_content") {
        $where_conditions[] = "(title LIKE '%$search_keyword%' OR content LIKE '%$search_keyword%')";
    }

    if (!empty($where_conditions)) {
        $where_clause = " WHERE " . implode(" AND ", $where_conditions);
    }
}

// 🔹 전체 게시글 개수 조회 (페이징 계산용)
$count_sql = "SELECT COUNT(*) AS total FROM freeboard" . $where_clause;
$count_result = mysqli_query($con, $count_sql);
$total_rows = mysqli_fetch_assoc($count_result)["total"];
$total_pages = ceil($total_rows / $limit);

// 🔹 게시글 목록 조회 (최신순 정렬 + 페이징 적용)
$sql = "SELECT f.*, 
            (SELECT COUNT(*) FROM comments c WHERE c.post_id = f.id) AS comment_count,
            (SELECT COUNT(*) FROM files fl WHERE fl.post_id = f.id) AS file_count
        FROM freeboard f" . $where_clause . " ORDER BY f.id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 목록</title>
</head>

<body>

    <h2><strong>게시판 목록</strong></h2>

    <!-- 검색 폼 -->
    <form action="index.php" method="get">
        <select name="search_type">
            <option value="title" <?= $search_type == "title" ? "selected" : "" ?>>제목</option>
            <option value="content" <?= $search_type == "content" ? "selected" : "" ?>>내용</option>
            <option value="title_content" <?= $search_type == "title_content" ? "selected" : "" ?>>제목 + 내용</option>
        </select>
        <input type="text" name="search_keyword" value="<?= htmlspecialchars($search_keyword) ?>" placeholder="검색어를 입력하세요.">
        <button>검색</button>
        <button type="button" oneclick="location.href='index.php'">초기화</button>
    </form>

    <!-- 게시글 목록 출력 -->
    <table border="">
        <thead>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>댓글</th>
                <th>파일</th>
                <th>작성일</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : // while문이 끝날때까지 변수가 유지된다다 
            ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td>
                        <a href="view.php?id=<?= $row["id"] ?>"><?= $row["title"] ?></a>
                        (<?= $row["comment_count"] ?>)
                    </td>
                    <td><?= htmlspecialchars($row["author"]) // html 태그가 실행되지 않도록! 위에는 뺐음 
                        ?></td>
                    <td><?= $row["comment_count"] > 0 ? "💬" : "" ?></td>
                    <td><?= $row["file_count"] > 0 ? "📎" : "" ?></td>
                    <td><?= $row["created_at"] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- 페이징 네비게이션 -->
    <div>
        <?php if ($page > 1) : ?>
            <a href="index.php?page=1<?= !empty($search_keyword) ? "&search_type=$search_type&search_keyword=$search_keyword" : "" ?>">처음</a>
            <a href="index.php?page=<?= $page - 1 ?><?= !empty($search_keyword) ? "&search_type=$search_type&search_keyword=$search_keyword" : "" ?>">이전</a>
        <?php endif; ?>

        페이지 <?= $page ?> / <?= $total_pages ?>

        <?php if ($page < $total_pages) : ?>
            <a href="index.php?page=<?= $page + 1 ?><?= !empty($search_keyword) ? "&search_type=$search_type&search_keyword=$search_keyword" : "" ?>">다음</a>
            <a href="index.php?page=<?= $total_pages ?><?= !empty($search_keyword) ? "&search_type=$search_type&search_keyword=$search_keyword" : "" ?>">마지막</a>
        <?php endif; ?>
    </div>
    <a href="form.php">
        <button>글쓰기</button>
    </a>
</body>

</html>