CREATE DATABASE basic;

USE basic;
CREATE TABLE freeboard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- 작성시간 자동 저장
);

ALTER TABLE freeboard 
ADD COLUMN name VARCHAR(50) NOT NULL AFTER id,  -- 작성자 이름 추가
ADD COLUMN password VARCHAR(255) NOT NULL AFTER name;  -- 비밀번호 추가
