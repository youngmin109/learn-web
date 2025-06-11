<?php
include __DIR__ . "/../includes/db_connect.php";  // DB 연결

// 검색 조건 설정
$search_type = isset($_GET["search_type"]) ? $_GET["search_type"] : "";
# 사용자가 같은 GET요청을 보냈는지 확인, 있으면 저장, 없으면 빈 문자열 저장
$search_keyword = isset($_GET["search_keyword"]) ? $_GET["search_keyword"] : "";
# 검색 키워드가 존재하는지 확인하고 저장, 없으면 빈 문자열 저장장

// 현재 페이지 설정 (GET으로 받고, 없으면 1페이지)
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
# page 값이 있는지 확인하고 있으면 해당 저장, 없으면 기본값 1
$limit = 5; // 한 페이지당 최대 5개
$offset = ($page - 1) * $limit; // 시작 위치(OFFSET) 계산
# SQL에서 특정 개수만큼 건너뛰고 데이터를 가져오는 역할할

// 전체 게시글 개수 조회
$count_sql = "SELECT COUNT(*) AS total FROM freeboard";
# SELECT COUNT(*) 테이블의 전체 행(게시글) 수를 가져옴
# AS total -> 결과의 컬럼 명을 지정 (나중에 $total_rows =)

# 검색 조건이 있을 경우, WHERE 절 추가
if (!empty($search_keyword)) {
    # 검색어가 있는 경우 실행됨
    $search_keyword = mysqli_real_escape_string($con, $search_keyword);
    # SQL 인젝션 방지 (특수 문자 자동 이스케이프 처리)
    # 인젝션 이란? -> 사용자가 입력한 값을 이용해 SQL 쿼리를 조작하여 데이터베이스를 
    # 공격하는 해킹 기법 
    $user_input = $_GET["search_keyword"];
    $sql = "SELECT * FROM freeboard WHERE subject LIKE '%$user_input%'";
    # [ 사용자가 만약 % or 1=1 을 입력하면 무조건 참이되어 필터 무력화]
    # 함수의 역할은 자동의 이스케이프 ( /% 처럼)
    if ($search_type == "title") {
        $count_sql .= " WHERE subject LIKE '%$search_keyword%'";
    } elseif ($search_type == "content") {
        $count_sql .= " WHERE content LIKE '%$search_keyword%'";
    } elseif ($search_type == "title_content") {
        $count_sql .= " WHERE subject LIKE '%$search_keyword%' OR content LIKE '%$search_keyword%'";
    }
}
# % -> 와일드카드 특수문자
# abc% -> abc로 시작하는 모든 데이터, a_c% -> a로 시작하고 2번째는 상관없고, 3번째는 c

$count_result = mysqli_query($con, $count_sql);
# 전체 게시글 수 조회
$total_rows = mysqli_fetch_assoc($count_result)["total"]; // 전체 게시글 수룰 가져옴
# 쿼리 결과를 연관 배열 형태로 반환
$total_pages = ceil($total_rows / $limit);
# 전체 헤이지 수 계산, 나눗셈 결과를 올림하여 총 페이지 수 계산산


// 테이블의 모든 레코드를 조회
$sql = "SELECT * FROM freeboard";

// 검색어가 있는 경우 WHERE 조건 추가
if (!empty($search_keyword)) {
    if ($search_type == "title") {
        $sql .= " WHERE subject LIKE '%$search_keyword%'";
    } elseif ($search_type == "content") {
        $sql .= " WHERE content LIKE '%$search_keyword%'";
    } elseif ($search_type == "title_content") {
        $sql .= " WHERE subject LIKE '%$search_keyword%' OR content LIKE '%$search_keyword%'";
    }
}

// 최신순 정렬 + 페이징 적용
$sql .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";  // 여기에 추가!
# 게시글을 아이디 기준으로 내림차순 정렬, 한페이지당 표시할 게시글 수, 페이지 시작위치
# 페이징 하는 구문 , OREDR BY 컬럼명 [ASC / DESC] LIMIT 숫자 OFFSET 숫자
$result = mysqli_query($con, $sql); # 객체(리소스) 형태로 저장
# 단순한 배열이 아닌 MySQL의 결과 집합을 포함한 객체, 데이터를 가져오려면 fetch_assoc등 함수를 써야함
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
    </form>

    <!-- 🔹 게시글 목록 출력 -->
    <table border="1">
        <thead>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>작성일</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><a href="view.php?id=<?= $row["id"] ?>"><?= htmlspecialchars($row["subject"]) ?></a></td>
                    <td><?= htmlspecialchars($row["name"]) ?></td>
                    <td><?= $row["created_at"] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- 🔹 페이징 네비게이션 -->
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
    <form action="index.php" method="get">
        <button type="submit">홈으로</button>
    </form>
</body>

</html>