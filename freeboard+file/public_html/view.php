<?php
            include __DIR__ . "/../includes/db.connect.php";

            // id 값 확인 
            if (!isset($_GET["id"])) {
                die("잘못된 접근입니다.");
            }
            $id = (int)$_GET["id"];

            // 게시글 데이터 가져오기
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


            // 댓글 가져오기 (대댓글 포함 정렬)
            $comment_sql = "SELECT * FROM comments WHERE post_id = $id ORDER BY parent_id ASC, created_at ASC";
            $comment_result = mysqli_query($con, $comment_sql);
            ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 보기</title>
</head>

<body>
    <h2><strong>게시글 보기</strong></h2>
    <table border=""></table>
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
            <td><pre><?= htmlspecialchars($row["content"]) ?></pre></td>
        </tr>
        <?php if ($file) : ?> <!-- 첨부파일이 있는 경우 -->
        <tr>
            <td><strong>첨부파일:</strong></td>
            <td><a href="download.php?file=<?= $file["stored_name"] ?>"><?= $file["original_name"] ?></a></td>
        </tr>
        <?php endif; ?>
    </table>

    <!-- 수정 삭제 버튼 -->
    <form action="modify_form.php">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button>수정</button>
    </form>
    <form action="delete.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button onclick="return confirm('정말 삭제?');">삭제</button>
    </form>
        
    <!-- 댓글 목록 -->
     <h3>댓글</h3>
     <?php while($comment = mysqli_fetch_assoc($comment_result)): ?>
        <p><strong><?= htmlspecialchars($comment["author"]) ?></strong> (<?= $comment["created_at"] ?>)</p>
        <p><?= htmlspecialchars($comment["comment"]) ?></p>

    <!-- 대댓글 작성 폼 -->
     <form action="comment_insert.php" method="post">
            <input type="hidden" name="post_id" value="<?= $id ?>">
            <input type="hidden" name="parent_id" value="<?= $comment["id"] ?>">
            <input type="text" name="author" value="익명" onfocus="if(this.value=='익명') this.value=''" onblur="if(this.value=='') this.value='익명'" required>
            <input type="password" name="password" placeholder="비밀번호 입력하세요" required>
            <textarea name="content" rows="2" required></textarea>
            <button>답글</button>
        </form>
        <hr>
        <?php endwhile; ?>
        <!-- 새 댓글 작성 폼 -->
        <h3>댓글 작성</h3>
        <form action="comment_insert.php" method="post">
            <input type="hidden" name="post_id" value="<?= $id ?>">
            <input type="hidden" name="parent_id" value="0"> <!-- 최상위 댓글 -->
            <input type="text" name="author" value="익명" onfocus="if(this.value=='익명') this.value=''" onblur="if(this.value=='') this.value='익명'" required>
            <input type="password" name="password" placeholder="비밀번호" required>
            <textarea name="content" rows="2" required></textarea>
            <button>댓글 등록</button>
        </form>
        <a href="index.php">
        <button >목록으로</button>
        </a>
     </body>
     </html>