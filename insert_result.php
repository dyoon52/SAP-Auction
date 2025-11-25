<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f9f9f9;
        }

        h1 {
            color: #444;
            font-size: 24px;
            background-color: #e8e8e8;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            margin-top: 50px;
        }

        p {
            font-size: 18px;
            color: #333;
        }
        
        a {
            font-size: 16px;
            color: #448AFF;
            text-decoration: none;
        }
        
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
    $con = mysqli_connect("localhost", "root", "xoo38699", "auctiondb");

    $userID = $_POST["userID"];
    $userPW = $_POST["userPW"];
    $userName = $_POST["userName"];
    $phoneNum = $_POST["phoneNum"];
    $userMail = $_POST["userMail"];
    $userAddr = $_POST["userAddr"];
    $detail_Addr = $_POST["detail_Addr"];

    $sql = "INSERT INTO usertbl (UserID, UserPW, UserName, PhoneNum, UserMail, UserAddr, Detail_Addr) VALUES ('".$userID."','".$userPW."','".$userName."','".$phoneNum."','".$userMail."','".$userAddr."','".$detail_Addr."')";

    $ret = mysqli_query($con, $sql);

    echo "<h1>신규 회원 입력 결과</h1>";
    if($ret) {
        echo "<p>데이터가 성공적으로 입력됨.</p>";
    } 
    else {
        echo "<p>데이터 입력 실패!!!</p>";
        echo "<p> 원인 : ".mysqli_error($con)."</p>";
 }

    mysqli_close($con);

    echo "<br> <a href='main.php'> 메인화면으로</a> ";
    ?>
</body>
</html>