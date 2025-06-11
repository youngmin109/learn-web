<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shape = $_POST['shape'];
    $rows = (int) $_POST['rows'];

    echo "<h2>선택한 도형 출력</h2>";
    echo "<pre>"; // 공백과 줄바꿈 유지
    $n = 5;
    switch ($shape) {

        case "sqaure":
            # 사각형
            # 입력값 받기

            for ($i = 0; $i < $n; $i++) {
                for ($j = 0; $j < $n; $j++)
                    echo '*' . ' ';
                echo "<br>";
            }

            break;

        case "triangle":
            # 삼각형
            # 입력값

            for ($i = 0; $i < $n; $i++) {

                for ($j = 0; $j < $i + 1; $j++)
                    echo '*';
                echo "<br>";
            }
            break;

        case "Xtriangle":
            # 역삼각형
            # 입력값

            for ($i = 0; $i < $n; $i++) {

                for ($j = 0; $j < $n - $i - 1; $j++)
                    echo "&nbsp";
                for ($j = 0; $j < $i + 1; $j++)
                    echo '*';
                echo "<br>";
            }
            break;

        case "pyramid":
            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $rows; $j++) {
                    echo "*";
                }
                echo "\n";
            }
            break;

        case "diamond":
            # 다이아몬드 별찍기
            # 입력값 받기
            # 피라미드
            for ($i = 0; $i < $n; $i++) {

                # 공백 
                for ($j = 0; $j < $n - $i - 1; $j++)
                    echo "&nbsp";
                # 별
                for ($j = 0; $j < ($i * 2) + 1; $j++)
                    echo '*';
                echo "<br>";
            }
            # 역피라미드
            for ($i = $n - 1; $i > 0; $i--) {

                # 공백
                for ($j = 0; $j;)
                    echo "&nbsp";
                # 별
                for ($j = 0; $j < ($i * 2) - 1;)
                    echo '*';
                echo "<br>";
            }
            break;

        default:
            echo "잘못된 선택입니다.";
    }

    echo "</pre>";
} else {
    echo "잘못된 접근입니다.";
}
