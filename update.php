<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userID = $_SESSION['userID'];
    $userPW = $_POST['UserPW'] ? "'" . $_POST['UserPW'] . "'" : "UserPW";
    $userName = $_POST['UserName'] ? "'" . $_POST['UserName'] . "'" : "UserName";
    $phoneNum = $_POST['PhoneNum'] ? "'" . $_POST['PhoneNum'] . "'" : "PhoneNum";
    $userMail = $_POST['UserMail'] ? "'" . $_POST['UserMail'] . "'" : "UserMail";
    $userAddr = $_POST['UserAddr'] ? "'" . $_POST['UserAddr'] . "'" : "UserAddr";
    $detailAddr = $_POST['Detail_Addr'] ? "'" . $_POST['Detail_Addr'] . "'" : "Detail_Addr";

    $con = mysqli_connect("localhost", "cookUser", "1234", "auctiondb");

    if (!$con) {
        die("데이터베이스 연결에 실패했습니다: " . mysqli_connect_error());
    }

    $sql = "UPDATE usertbl SET UserPW=$userPW, UserName=$userName, PhoneNum=$phoneNum, UserMail=$userMail, UserAddr=$userAddr, Detail_Addr=$detailAddr WHERE UserID='$userID'";
    
    if (mysqli_query($con, $sql)) {
        header("Location: member_info.php");
    } else {
        die("쿼리 실행에 실패: " . mysqli_error($con));
    }

    mysqli_close($con);
}
?>
