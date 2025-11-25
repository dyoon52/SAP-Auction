<?php
session_start();

$userID = $_SESSION['userID'];

$con = mysqli_connect("localhost", "root", "1234", "auctiondb");

if (!$con) {
    die("데이터베이스 연결에 실패했습니다: " . mysqli_connect_error());
}

$sql = "SELECT * FROM usertbl WHERE UserID = '$userID'";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("쿼리 실행에 실패: " . mysqli_error($con));
}

$row = mysqli_fetch_assoc($result);
mysqli_close($con);
?>


<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원 정보 수정</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }
        
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .button {
            background-color: #8c24ec;
            border: none;
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #6c1bc5;
        }

        
        table {
            margin-bottom: 1rem;
        }
        
        h1 {
            color: #8c24ec;
            font-size: 24px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>회원 정보 수정</h1>
        <form action="update.php" method="post">
            <table>
                <tr>
                    <td>아이디:</td>
                    <td><?= $row['UserID'] ?></td>
                    <td><input type="hidden" name="UserID" value="<?= $row['UserID'] ?>"></td>
                </tr>
                <tr>
                    <td>비밀번호:</td>
                    <td><?= $row['UserPW'] ?></td>
                    <td><input type="password" name="UserPW" placeholder="새 비밀번호"></td>
                </tr>
                <tr>
                    <td>이름:</td>
                    <td><?= $row['UserName'] ?></td>
                    <td><input type="text" name="UserName" placeholder="새로운 이름"></td>
                </tr>
                <tr>
                    <td>전화번호:</td>
                    <td><?= $row['PhoneNum'] ?></td>
                    <td><input type="text" name="PhoneNum" placeholder="새 전화번호"></td>
                </tr>
                <tr>
                    <td>이메일:</td>
                    <td><?= $row['UserMail'] ?></td>
                    <td><input type="email" name="UserMail" placeholder="새 이메일"></td>
                </tr>
                <tr>
                    <td>주소:</td>
                    <td><?= $row['UserAddr'] ?></td>
                    <td><input type="text" name="UserAddr" placeholder="새 주소"></td>
                </tr>
                <tr>
                    <td>상세 주소:</td>
                    <td><?= $row['Detail_Addr'] ?></td>
                    <td><input type="text" name="Detail_Addr" placeholder="새 상세 주소"></td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td colspan="3"><input type="submit" value="수정" class="button"></td>
                </tr>
            </table>
        </form>
        <a href="main.php" class="button">메인 페이지로 돌아가기</a>
        <a href="delete.php" class="button" style="float:right"; onclick="return confirm('정말로 회원 탈퇴를 하시겠습니까?');">회원탈퇴</a>
    </div>
</body>
</html>
