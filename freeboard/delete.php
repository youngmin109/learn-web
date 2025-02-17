<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["num"])) {
        die("잘못된 접근입니다.");
    }

    $num = $_POST["num"];

    $con = mysqli_connect("localhost", "user", "12345", "user");
    $sql = "DELETE FROM freeboard WHERE num=$num";
    mysqli_query($con, $sql);
    mysqli_close($con);

    header("Location: list.php");
    exit();
} else {
    die("잘못된 접근입니다.");
}
?>