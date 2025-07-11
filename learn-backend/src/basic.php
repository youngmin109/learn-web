
<?php
    include ('include.php');

    echo sum(1, 2);

    // 함수 정의
    function bar($arg) 
    {
        foreach ($arg as $key => $value) {
            echo "{$key} => {$value}<br>";
        }
    }

    $foo = [1, 2, 3];
    bar($foo);

    // 변수
    // 생명주기
    // 자바 -> 블럭 기반, python, php -> 함수 기반

    $bar = "hello world"; // 변수 선언
    
    foo(); // 호이스트 함수 호출
    function foo() {
        // global $bar; // 전역 변수 사용
        // print $bar; // 전역 변수 출력
        print $GLOBALS['bar'];
        print "<br>";
        print $_GET['foo'];
        print "<br>";
        print $_GET['sign'];
    }
    
    // 연산자
    // 1) 기능 
    // 2) 우선순위
    // 3) 이항연산 시 묵시적 형변환 규칙

    $bob = 1;
    $foo = 1.0;

    if ($bob == $foo) {
        print "같다";
    } else {
        print "다르다";
    }

    echo 'ls -la';
    // HashMap
    // 해쉬맵이란 키-값 쌍으로 데이터를 저장하는 자료구조이다.
    // PHP에서는 연관 배열(associative array)로 구현되어 있다.
    $array1 = [1, 2, 3];
    $array2 = [1, 2 => 3, 1 => 2];
    if ($array1 == $array2) {
        print "True";
    } else {
        print "False";
    }
    echo "<br>";
    // foreach
    foreach ($array1 as $key => $value) {
        print "{$key} => {$value}<br>";
    }

    // 폐쇄 함수 (Closure)
    // 상태값을 가져오는 방식 2가지 , 캡처와 참조
    $hoo = function() use ($bar){
        echo "hello<br>".$bar;
    };

    $bar = "bye world"; // 변수 재정의
    $hoo();
?>