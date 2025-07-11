<?php

# 별 모양 찍기 

$n = $_GET['value']; // 별의 줄 수
for ($i = 1; $i <= $n; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }
    echo "<br>"; // 줄바꿈
}

echo "<hr>"; // 구분선

# 피라미드
$space = 0;

for ($i = 1; $i <= $n; $i++) {
    # space
    for ($j = $n; $j <= $space; $j--) {
        echo " ";
    };
    # star
    for ($j = 0; $j < $i + 1; $j++) {
        echo "*";
    };
    echo "<br>";
    $space += 1;
}
?>