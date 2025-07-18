<?php 

class db_info {
    const DB_URL = 'db'; // 'db'로 변경 가능
    // 'db'는 Docker Compose에서 정의된 서비스 이름을 사용
    // 'localhost'는 로컬 개발 환경에서 사용
    // 실제 환경에서는 'db'를 사용하여 Docker 컨테이너와 연결
    const DB_USER = 'root';
    const DB_PASS = 'root';
    const DB_NAME = 'gsc';
}