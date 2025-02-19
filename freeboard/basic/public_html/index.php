<?php
include __DIR__ . "/../includes/db_connect.php";  // DB 연결

// 🔹 검색 조건 설정
$search_type = isset($_GET["search_type"]) ? $_GET["search_type"] : "";
$search_keyword = isset($_GET["search_keyword"]) ? $_GET["search_keyword"] : "";


// 게시글 목록 가져오기 (최신순 정렬)
$sql = "SELECT * FROM freeboard";

// 🔹 검색어가 있는 경우 WHERE 조건 추가
if (!empty($search_keyword)) {
    $search_keyword = mysqli_real_escape_string($con, $search_keyword); // SQL 인젝션 방지
    if ($search_type == "title") {
        $sql .= " WHERE subject LIKE '%$search_keyword%'";
    } elseif ($search_type == "content") {
        $sql .= " WHERE content LIKE '%$search_keyword%'";
    } elseif ($search_type == "title_content") {
        $sql .= " WHERE subject LIKE '%$search_keyword%' OR content LIKE '%$search_keyword%'";
    }
}

// 🔹 최신순 정렬
$sql .= " ORDER BY id DESC";

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
    <!-- 🔹 검색 폼 -->
    <form action="index.php" method="get">
        <select name="search_type">
            <option value="title" <?= $search_type == "title" ? "selected" : "" ?>>제목</option>
            <option value="content" <?= $search_type == "content" ? "selected" : "" ?>>내용</option>
            <option value="title_content" <?= $search_type == "title_content" ? "selected" : "" ?>>제목 + 내용</option>
        </select>
        <input type="text" name="search_keyword" value="<?= htmlspecialchars($search_keyword) ?>" placeholder="검색어 입력">
        <button type="submit">검색</button>
    </form>
    

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