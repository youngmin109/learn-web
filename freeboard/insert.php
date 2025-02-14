<?php
    // **한국 시간(KST)으로 설정**
    date_default_timezone_set("Asia/Seoul");

    # 사용자가 입력한 내용을 POST방식으로 받아 각각 저장
	$name = $_POST["name"];				// 이름
	$pass = $_POST["pass"];				// 비밀번호
    $subject = $_POST["subject"];		// 제목
    $content = $_POST["content"];		// 내용

    # html함수를 사용하여 제목과 내용에 포함된 특수 기호를
    # HTML표기로 변환하여 다시 저장장
	$subject = htmlspecialchars($subject, ENT_QUOTES);	// NOQUOTES하면 ",' 표기변환X
	$content = htmlspecialchars($content, ENT_QUOTES);
	$regist_day = date("Y-m-d (H:i)");  // UTC 기준 현재의 '년-월-일 (시:분)'

    # MySQL 데이터베이스에 접속
	$con = mysqli_connect("localhost", "user", "12345", "user");	// DB 연결

    # SQL 명령으로 값을 저장
	$sql = "insert into freeboard (name, pass, subject, content, regist_day) ";	// 레코드 삽입 명령
	$sql .= "values('$name', '$pass', '$subject', '$content', '$regist_day')";

    // $sql에 저장된 명령 실행
	mysqli_query($con, $sql);  

	mysqli_close($con);       // DB 연결 끊기

    # 저장 후 글쓰기 폼으로 이동
    header("Location: form.php");
    exit();
?>

