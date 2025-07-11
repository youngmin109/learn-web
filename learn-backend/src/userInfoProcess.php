<?php
if( isset($_POST['user_name']) && isset($_POST['user_name']) ) {
    echo "{$_POST['user_name']}님 환영합니다.<br>";
    echo "저도 {$_POST['user_age']}살 입니다.";    
} else { 
    echo "이름과 나이를 입력해주세요.";
}

?>