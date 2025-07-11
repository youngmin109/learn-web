<?php
echo "asodkoskd";
// 1) 쿠키 생성 요청 (A)
setcookie("bar", "milk11"); 
setcookie("foo", "apple11", time() + 3600); // 1시간 후 만료
setcookie("baz", "banana11", time() - 3600); // 즉시 만료 (삭제)
// 쿠키는 변수
// bar = milk 쿠키는 key-value 쌍으로 구성

// 2) 쿠키 생성 (C)
// Web 브라우저가 local에 쿠기 정보를 파일로 저장
// 도메인 단위 관리 : localhost/bar=milk

// 3) 쿠키 전달 (C)
// 쿠키는 HTTP 헤더에 포함되어 전달됨
// 클라이언트가 서버에 요청할 때 쿠키 정보가 함께 전송됨
// 서버는 appserver에 쿠키 정보를 전달

// 4) 쿠키 읽기 (A)
