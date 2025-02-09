<?php
	# 다이아몬드 별찍기
	# 입력값 받기
	$n = 5;
	# 피라미드
	for ($i=0; $i<$n; $i++){
	
		# 공백 
		for ($j=0; $j<$n-$i-1; $j++)
			echo "&nbsp";
		# 별
		for ($j=0; $j<($i*2)+1; $j++)
			echo '*';	
		echo "<br>";
	}; 
	# 역피라미드
	for ($i=$n-1; $i>0; $i--){

		# 공백
		for ($j=0; $j;)
			echo "&nbsp";
		# 별
		for ($j=0; $j<($i*2)-1;)
			echo '*';
		echo "<br>";
	};
?>