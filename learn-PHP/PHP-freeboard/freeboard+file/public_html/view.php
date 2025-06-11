<?php
include __DIR__ . "/../includes/db_connect.php";  // DB 연결

// 게시글 ID 확인 후 ID를 가져옴 (댓글 1)
if (!isset($_GET["id"])) {
    die("잘못된 접근입니다.");
}
$id = (int)$_GET["id"];

$sql = "SELECT * FROM freeboard WHERE id = $id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// 게시글이 존재하지 않으면 오류 처리
if (!$row) {
    die("해당 게시글이 존재하지 않습니다.");
}

// 첨부 파일 가져오기
$file_sql = "SELECT * FROM files WHERE post_id = $id";
$file_result = mysqli_query($con, $file_sql);
$file = mysqli_fetch_assoc($file_result);

// 댓글 가져오기 (핵심2) - 현재 보고있는 게시글 -> post_id  
$comment_sql = "SELECT * FROM comments WHERE post_id = $id 
                ORDER BY parent_id ASC, created_at ASC";
// 계층구조로 정렬! null인 댓글 가장먼저 정렬,
$comment_result = mysqli_query($con, $comment_sql);

// 댓글을 트리 구조로 저장할 배열
$comments = [];
while ($comment = mysqli_fetch_assoc($comment_result)) {
    $comments[$comment['parent_id']][] = $comment;
}
// 이해 필요!
// $comments = [
//     NULL => [     // 부모 댓글 (parent_id가 NULL)
//         ["id" => 1, "content" => "부모 댓글 1"],
//         ["id" => 3, "content" => "부모 댓글 2"]
//     ],
//     1 => [        // id가 1인 부모 댓글의 대댓글
//         ["id" => 2, "content" => "대댓글 1-1"],
//         ["id" => 4, "content" => "대댓글 1-2"]
//     ],
//     4 => [        // id가 4인 댓글(대댓글 1-2)의 대대댓글
//         ["id" => 5, "content" => "대대댓글 1-2-1"]
//     ],
//     3 => [        // id가 3인 부모 댓글의 대댓글
//         ["id" => 6, "content" => "대댓글 2-1"]
//     ]
// ]; 

# 재귀 함수(Recursion)는 함수 안에서 자기 자신을 호출하는 함수
// 댓글을 계층적으로 출력하는 함수
function display_comments($parent_id = NULL, $depth = 0)
{ // 기본 값은 NULL 이지만 직접값을 전달하면 기본 값 무시
    global $comments;
    if (!isset($comments[$parent_id])) {
        return;
        // 더이상 하위 댓글이 없으면 탈출
    }
    echo "<ul>";
    foreach ($comments[$parent_id] as $comment) {
        echo "<li>";
        echo str_repeat(" ", $depth) . "<strong>{$comment["author"]}</strong>: {$comment["content"]} <br>";
        echo "<small>{$comment["created_at"]}</small> ";
        
        // 대댓글 작성 -> reply_form
        echo "<a href='reply_form.php?parent_id={$comment["id"]}&post_id={$_GET["id"]}'>답글 달기</a>";
        
        // 댓글 삭제 폼
        echo "<form action='comment_delete.php' method='POST' style='display:inline;'>";
        echo "<input type='hidden' name='comment_id' value='{$comment["id"]}'>";
        echo "<input type='password' name='password' placeholder='비밀번호 입력' required>";
        echo "<button type='submit' onclick='return confirm(\"댓글을 삭제하시겠습니까?\");'>삭제</button>";
        echo "</form>";
        
        display_comments($comment["id"], $depth + 1); // 대댓글 출력 (재귀함수)
        echo "</li>";
    }
    echo "</ul>";
}
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>게시글 보기</title>
</head>

<body>
    <h2>게시글 보기</h2>
    <table border="1">
        <tr>
            <td><strong>제목:</strong></td>
            <td><?= htmlspecialchars($row["title"]) ?></td>
        </tr>
        <tr>
            <td><strong>작성자:</strong></td>
            <td><?= htmlspecialchars($row["author"]) ?></td>
        </tr>
        <tr>
            <td><strong>작성일:</strong></td>
            <td><?= $row["created_at"] ?></td>
        </tr>
        <tr>
            <td><strong>내용:</strong></td>
            <td>
                <pre><?= htmlspecialchars($row["content"]) ?></pre>
            </td>
        </tr>
        <?php if ($file) : ?>
            <tr>
                <td><strong>첨부파일:</strong></td>
                <td><a href="download.php?file=<?= urlencode($file["stored_name"]) ?>">
                    <?= htmlspecialchars($file["original_name"]) ?></a></td>
            </tr>
        <?php endif; ?>

    </table>

    <!-- 수정, 삭제 버튼 -->
    <h3>게시글 관리</h3>
    <form action="modify_form.php" method="get">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button>수정</button>
    </form>

    <form action="delete.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="password" name="password" placeholder="비밀번호 입력" required>
        <button onclick="return confirm('정말 삭제하시겠습니까?');">삭제</button>
    </form>

    <h3>댓글</h3>
    <?php display_comments(); ?>

    <h3>댓글 작성</h3>
    <form action="comment_insert.php" method="POST">
        <input type="hidden" name="post_id" value="<?= $id ?>">
        <input type="text" name="author" placeholder="이름" required>
        <input type="password" name="password" placeholder="비밀번호" required>
        <textarea name="content" placeholder="댓글을 입력하세요" required></textarea>
        <button type="submit">등록</button>
    </form>

    <a href="index.php">
        <button>목록으로</button>
    </a>
</body>

</html>