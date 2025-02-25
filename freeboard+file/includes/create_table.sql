CREATE DATABASE file_comment_freeboard
    DEFAULT CHARACTER SET = 'utf8mb4';
USE file_comment_freeboard

CREATE TABLE freeboard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)

CREATE TABLE files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL, -- 어떤 게시글에 속하는 파일인지 (FK)
    original_name VARCHAR(255) NOT NULL, -- 사용자가 업로드한 원본 파일명
    stored_name VARCHAR(255) NOT NULL, -- 서버에 저장된 파일명
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES freeboard(id) ON DELETE CASCADE
)

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL, -- (FK)
    parent_id INT NOT NULL, -- 부모 댓글 (ID) NULL이면 일반 댓글
    author VARCHAR(100) NOT NULL, -- 댓글 작성자
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES freeboard(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE
)