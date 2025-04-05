#!/bin/bash

# 1. MYSQL 데몬 실행에 필요한 디렉토리 생성
mkdir -p /var/run/mysqld
chown mysql:mysql /var/run/mysqld

# 2. MYSQL 시작
service mysql start

# 3. root 사용자 비밀번호 설정
mysql -e "ALTER USER 'root'@'localhost' \
IDENTIFIED WITH mysql_native_password BY 'root123'; \
FLUSH PRIVILEGES;"

# 4. PHP-FPM 시작
service php8.3-fpm start

# 5. Nginx 포그라운드 실행 (컨테이너 종료 방지)
nginx -g "daemon off;"

# nginx는 반드시 포그라운드 모드로 실행해야 컨테이너가 유지

