<?php
session_start();

if (!isset($_SESSION['userID'])) {
    die("로그인이 필요합니다.");
}

$userID = $_SESSION['userID'];

$con = mysqli_connect("localhost", "root", "xoo38699", "auctiondb");

if (!$con) {
    die("데이터베이스 연결에 실패했습니다: " . mysqli_connect_error());
}

$sql = "DELETE FROM usertbl WHERE UserID = '$userID'";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("쿼리 실행에 실패: " . mysqli_error($con));
}

header("Location: logout.php");
exit;
?>
