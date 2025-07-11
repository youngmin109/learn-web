<?php
    # $planet = $_GET['id'];
    $speed_of_Light = 300000;
    # 수성
    if ($_GET['planet'] == 'mercury') {
        $value = 57900000;
    } else if ($_GET['planet'] == 'earth') {  
        $value = 150000000;
    } else if ($_GET['planet'] == 'mars') {
        $value = 230000000;
    }
    $time = round($value / $speed_of_Light / 60, 2);
    echo "Trave tile from Sun to mercury :  $time minutes";
?>