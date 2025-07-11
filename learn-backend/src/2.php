<?php
    $arrayValue = $_POST['value']; // 리스트
    $count = count($arrayValue); // 입력 값의 개수
    
    // 입력 값 출력
    echo "입력 값 : ";
    foreach ($arrayValue as $value) {
        echo $value . " ";
    }

    // 평균
    $sum = array_sum($arrayValue);
    $average = $sum / $count;
    echo "<br>" . "평균 : " . $average;
    
    // 분산
    $variable = 0;
    foreach ($arrayValue as $value) {
        
        $variable += pow($value - $average, 2);

    }
    $variable = round($variable / $count - 1, 2);
    echo "<br>" . "분산 : " . $variable;

    // 편차
    $sigma = round(sqrt($variable), 2);
    echo "<br>" . "표준편차 : " . $sigma;

?>