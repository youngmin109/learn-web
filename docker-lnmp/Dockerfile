# 1. 베이스 이미지 선택
FROM ubuntu:latest

# 2. 환경 비변수 설정
ENV DEBIAN_FRONTEND=nointeractive

# 3. 패키지 업데이트 및 LNMP 구성 요소 설치
RUN apt update && apt install -y \
    nginx \
    php-fpm \
    php-mysql \
    mysql-server \
    vim \
    curl \
    lsb-release \
    net-tools

# 4. MYSQL 데몬 디렉토리 생성
RUN mkdir -p /var/run/mysqld && chmod 755 /var/run/mysqld

# 5. Nginx PHP 연동 설정 파일 덮어쓰기
COPY default /etc/nginx/sites-available/default

# 6. 실행 스크립트 복사 및 실행 권한 부여
COPY start.sh /start.sh
RUN chmod +x /start.sh

# 7. 포트 오픈 (HTTP 80)
EXPOSE 80

# 8. 컨테이너 시작 시 실행할 명령 설정
CMD ["/start.sh"]