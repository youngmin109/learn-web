<?php
    // print($_GET['id']);

    // POST or GET 입력 값 사용 전, 반드시 입력 값에 대한 검증이 필요하다.
    // 1. 입력 값의 존재 여부 

    function http_response_error($msg) {
        http_response_code(400);
        echo $msg."<br>";
        exit;
    }

    if (!isset($_POST["id"]) || !isset($_POST["pw"])) {
        http_response_error("입력값을 확인하세요");
    }

    // 2. 문자열 전처리
    $id = trim($_POST["id"]);
    $pw = trim($_POST["pw"]);
    
    // 3. option : 각 필드별 특성 처리
    if(!is_numeric($pw)) {
        http_response_error("패스워드는 숫자로 구성됩니다.");
    }

    if ($id === '') {
        http_response_error("id를 입력하세요");
    }
    var_dump($_POST);
    echo "입력값 검증 완료";
?>