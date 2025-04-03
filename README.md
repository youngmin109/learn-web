# Web System & Container Environment (Study Log)

## 📅 Timeline
- **2024.11 ~**: HTML & CSS
- **2024.12 ~ 2025.03.03**: Client & Server 구조 학습
- **2025.02.03 ~ 2025.03.03**: PHP & MySQL 실습
- **2025.03.04 ~**: Web System 구조 및 동작 원리 정리
- **2025.04 ~**: JavaScript 학습 시작

---

## 🎯 학습 배경 및 목적
서버-클라이언트 기반 웹 시스템을 이해하고,  
PHP와 MySQL을 이용한 동적 웹페이지 구현 및  
Docker를 활용한 가상화 환경 구성 능력 향상을 목표로 학습 중입니다.

---

## 📚 주요 학습 내용 요약

### Web System 기초
- **WWW & HTTP**
  - HTTP의 비연결성, 무상태성
  - 클라이언트-서버 구조 및 요청/응답 흐름 이해
- **HTML / CSS / JavaScript**
  - 정적 페이지 구성 요소 및 브라우저 렌더링 동작 원리
- **Web Server (Apache / Nginx)**
  - 정적 vs 동적 콘텐츠 처리
  - 웹서버 구성 요소 및 역할

### PHP & MySQL
- PHP를 통한 서버 사이드 스크립트 작성
- MySQL을 이용한 데이터 CRUD 처리

### URL & HTTP 프로토콜
- URI/URL의 구조와 인코딩 원리
- HTTP 요청/응답 메시지 구조 및 상태 코드 이해

---

## 🐳 Containerization with Docker

### 이미지와 컨테이너
- **Image**: 실행 환경의 템플릿 (읽기 전용)
- **Container**: 이미지로부터 생성된 실행 인스턴스 (독립 실행 환경)

### 기본 명령어 실습
- `docker pull`, `create`, `start`, `stop`, `rm`, `rmi`
- 컨테이너 내부 명령어 실행: `docker exec -it`

### 데이터 저장 방식
| 저장 방식 | 설명 | 지속성 |
|-----------|------|--------|
| Writable Layer | 컨테이너 내부 임시 저장소 | 컨테이너 삭제 시 함께 삭제 |
| Volume | Docker가 관리하는 외부 저장소 | 유지됨 |
| Bind Mount | Host 디렉토리 실시간 반영 | 개발 시 유용 |

### 이미지 커밋 & Dockerfile
- 컨테이너 상태를 저장: `docker commit`
- 설정 기반 자동 이미지 빌드: `Dockerfile`

---

## 🔗 Reference
- [Web System Notion 기록](https://www.notion.so/1-Web-system-1adb6d9c51e280b3817bc6d12b77d71d?pvs=4)
- [TIL 기록용 Notion](https://www.notion.so/TIL-16c59b1929de800f8638c1ba8c5140b6?pvs=4)

---

> **Note:**  
> 본 README는 정리 및 복습용으로 작성되었으며,  
> 이후 JavaScript 비동기 처리, Node.js, REST API 설계, 웹 보안 관련 내용도 추가 예정입니다.
