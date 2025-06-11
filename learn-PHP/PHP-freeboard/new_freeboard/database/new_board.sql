-- 새 데이터베이스 생성
CREATE DATABASE new_freeboard;
USE new_freeboard;

-- 회원 정보 테이블
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    username VARCHAR(50) UNIQUE NOT NULL, 
    password VARCHAR(255) NOT NULL, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 게시판 테이블
CREATE TABLE freeboard (
    num INT AUTO_INCREMENT PRIMARY KEY, 
    user_id INT NOT NULL, 
    subject VARCHAR(100) NOT NULL, 
    content TEXT NOT NULL, 
    regist_day TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
