<?php
// session_start();

if(session_id() !='') {
    echo "세션이 이미 시작되었습니다.";
}

if(session_status() == PHP_SESSION_ACTIVE) {
    echo "<br> 세션이 활성화되어 있습니다.";
}

$_SESSION['std_info'] = [
    'name' => '배영민',
    'age' => 28,
    'email' => 'youngmin@example.com'
];

?>