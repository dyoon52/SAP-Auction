<!DOCTYPE html<html>
<head>
  <meta charset="UTF-8">
 <title>Login Result</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #f1f1f1;
    }

    #container {
      margin: 50px auto;
      width: 400px;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 30px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    h1 {
      margin: 0 0 20px 0;
      font-size: 24px;
 font-weight: bold;
      text-align: center;
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-size: 16px;
      font-weight: bold;
    }

    input[type=text], input[type=password] {
      width: 100%;
      height: 40px;
      padding: 10px;
      font-size: 16px;
      border-radius: 3px;
      border: px solid #ccc;
      box-sizing: border-box;
    }

    .btn {
      display: inline-block;
      background-color: #4caf50;
      color: #fff;
      padding: 10px 20px;
      font-size: 16px;
      font-weight: bold;
      text-align: center;
      border: none;
      border: 3px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #3e8e41;
    }

    .btn:active {
      background-color: #1f4c13;
    }

    .error {
      color: red;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .link-wrapper {
    text-align: center;
    margin-top: 10;
}

.link-wrapper a {
    display: inline-block;
}

.error-wrapper {
    text-align: center;
    margin-bottom: 20px;
}
  </style>
</head>

<body>
  <div id="container">
    <h1>로그인 결과</h1>
    <?php
    session_start(); // 세션 시작

    $con = mysqli_connect("localhost", "root", "xoo38699", "auctiondb");
    $userID = $_POST["userID"];
    $userPW = $_POST["userPW"];

    $sql = "SELECT * FROM usertbl WHERE UserID='".$userID."' AND UserPW='".$userPW."'";

    $result = mysqli_query($con, $sql); // 누락된 부분 수정
    $row = mysqli_fetch_array($result);

    if($row) {
      $_SESSION["userID"] = $userID; // 세션에 로인한 사용자의 ID 저장
      header("Location: main.php");
      exit;
    } else {
      echo "<div class='error-wrapper'><div class='error'>아이디 또는 비밀번호가 잘못되었습니다.</div>";
      echo "<p class='link-wrapper'><a href='main.php'class='btn'>로그인 화면으로</a></p>";
    }

    mysqli_close($con);
    ?>
  </div>
</body>
</html>
