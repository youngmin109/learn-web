<pre>
<?php
    # 별찍기
    $n = 5;

    for($i=0; $i<$n; $i++) {

      for ($j=0; $j < $n-$i-1; $j++) {
          echo " ";
      }
      // 별 출력
      for ($j=0; $j < (2 * $i + 1); $j++) {
        echo "*";
      }
      echo "<br>";
    }
?>
</pre>