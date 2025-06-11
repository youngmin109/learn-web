DROP DATABASE IF EXISTS file_comment_freeboard;
CREATE DATABASE file_comment_freeboard DEFAULT CHARACTER SET = 'utf8mb4';
USE file_comment_freeboard;

-- 📌 1) 게시글 테이블 (freeboard)
CREATE TABLE freeboard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 📌 2) 댓글 테이블 (comments)
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,   -- 어느 게시글에 속하는 댓글인지
    parent_id INT DEFAULT NULL,  -- 부모 댓글 ID (NULL이면 최상위 댓글)
    author VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES freeboard(id) ON DELETE CASCADE,  
    FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE)

-- 📌 3) 파일 업로드 테이블 (files)
CREATE TABLE files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,  -- 어느 게시글에 속하는 파일인지
    original_name VARCHAR(255) NOT NULL,  -- 원래 파일명
    stored_name VARCHAR(255) NOT NULL,  -- 서버에 저장된 파일명
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES freeboard(id) ON DELETE CASCADE
);

