-- -------------------------------
-- DATABASE & CHARACTER SET 설정
-- -------------------------------
CREATE DATABASE IF NOT EXISTS gsc
    CHARACTER SET utf8mb4           -- 다국어 및 이모지 지원
    COLLATE utf8mb4_general_ci;

USE gsc;

-- -------------------------------
-- 사용자 테이블 (회원 정보)
-- -------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- 고유 사용자 ID (PK)
    username VARCHAR(50) NOT NULL UNIQUE,        -- 로그인 ID (중복 불가)
    password VARCHAR(255) NOT NULL,              -- 해시된 비밀번호
    name VARCHAR(100) NOT NULL                   -- 사용자 실명 또는 닉네임
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------
-- 게시글 테이블 (게시판 본문)
-- -------------------------------
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,              -- 게시글 고유 ID (PK)
    user_id INT NOT NULL,                           -- 작성자 ID (FK to users.id)
    title VARCHAR(255) NOT NULL,                    -- 게시글 제목
    content TEXT NOT NULL,                          -- 게시글 본문
    views INT NOT NULL DEFAULT 0,                   -- 조회수 (기본 0)
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,  -- 작성일
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, -- 수정일
    CONSTRAINT fk_posts_user FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE                               -- 사용자가 삭제되면 게시글도 함께 삭제
    ON UPDATE CASCADE                               -- 사용자 ID 변경 시 연동
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
