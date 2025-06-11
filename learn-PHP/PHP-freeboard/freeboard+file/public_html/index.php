<?php
include __DIR__ . "/../includes/db_connect.php"; // DB 연결

// 검색 조건 설정
$search_type = isset($_GET["search_type"]) ? $_GET["search_type"] : "";
$search_keyword = isset($_GET["search_keyword"]) ? $_GET["search_keyword"] : "";

// 현재 페이지 설정 (GET으로 받고, 없으면 1페이지)
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$limit = 5; // 한 페이지에 표시할 게시글 수
$offset = ($page - 1) * $limit; // 시작 위치 (OFFSET) 계산

// 전체 게시글 개수 조회
$count_sql = "SELECT COUNT(*) AS total FROM freeboard";
if (!empty($search_keyword)) {
    $search_keyword = mysqli_real_escape_string($con, $search_keyword);
    $count_sql .= " WHERE title LIKE '%$search_keyword%' OR content LIKE '%$search_keyword%'";
}
$count_result = mysqli_query($con, $count_sql);
$total_rows = mysqli_fetch_assoc($count_result)["total"];
$total_pages = ceil($total_rows / $limit);

// 게시글 목록 가져오기
$sql = "SELECT f.*, 
            (SELECT COUNT(*) FROM comments c WHERE c.post_id = f.id) AS comment_count,
            (SELECT COUNT(*) FROM files fl WHERE fl.post_id = f.id) AS file_count
        FROM freeboard f";

// 검색어가 있는 경우 WHERE 조건 추가
if (!empty($search_keyword)) {
    $sql .= " WHERE f.title LIKE '%$search_keyword%' OR f.content LIKE '%$search_keyword%'";
}

// 최신순 정렬 + 페이징 적용
$sql .= " ORDER BY f.id DESC LIMIT $limit OFFSET $offset";
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
    
    <!-- 검색 폼 -->
    <form action="index.php" method="get">
        <select name="search_type">
            <option value="title" <?= $search_type == "title" ? "selected" : "" ?>>제목</option>
            <option value="content" <?= $search_type == "content" ? "selected" : "" ?>>내용</option>
            <option value="title_content" <?= $search_type == "title_content" ? "selected" : "" ?>>제목 + 내용</option>
        </select>
        <input type="text" name="search_keyword" value="<?= htmlspecialchars($search_keyword) ?>" placeholder="검색어 입력">
        <button>검색</button>
        <button type="button" onclick="location.href='index.php'">초기화</button>
    </form>

    <!-- 게시글 목록 출력 -->
    <table border="1">
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
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td>
                        <a href="view.php?id=<?= $row["id"] ?>"><?= htmlspecialchars($row["title"]) ?></a>
                        (<?= $row["comment_count"] ?>)
                    </td>
                    <td><?= htmlspecialchars($row["author"]) ?></td>
                    <td><?= $row["comment_count"] > 0 ? "O" : "X" ?></td>
                    <td><?= $row["file_count"] > 0 ? "O" : "X" ?></td>
                    <td><?= $row["created_at"] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!--페이징 네비게이션 -->
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

    <!-- 글쓰기 버튼 -->
    <form action="form.php" method="get">
        <button>글쓰기</button>
    </form>
</body>
</html>
