<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>제품 업로드 결과</title>
    <!-- 스타일 추가 -->
    <style>
        body {
            font-family: "Arial", sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 30px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24        }
        p {
            font-size: 14px;
        }
        a {
            font-size: 14px;
            background-color: #555555;
            color: #ffffff;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
<?php
// 데이터베이스 연결
$conn = new mysqli('localhost', 'root', '1234', 'auctiondb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 폼에서 전송된 값 가져오기
$userID = $_POST['userID'];
$title = $_POST['Title'];
$content = $_POST['content'];
$category = $_POST['category'];
$sellType = $_POST['sellType'];

$normalProductDetails = $_POST['price'];
$nState = $_POST['nState'];

$startPrice = $_POST['startPrice'];
$buynowPrice = $_POST['buynowPrice'];
$period = $_POST['period'];

// 이미지 데이터 가져오기
$postImg = file_get_contents($_FILES['postImg']['tmp_name']);
$postImg = mysqli_real_escape_string($conn, $postImg);

// SQL 쿼리 생성
$sql = "INSERT INTO post (userID, PostTitle, content, Category, sellType, PostImg)
VALUES ('$userID', '$title', '$content', '$category', '$sellType', '$postImg')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "<h1>새로운 레코드가 성공적으로 생성되었습니다.</h1>";

    // 상품 정보 업로드
    if ($sellType == "normal") {
        $sql = "INSERT INTO normalprod (Post_no, Price, N_State)
        VALUES ('$last_id', '$normalProductDetails', '$nState')";
    } else {
        $currentDateTime = new DateTime();
        $endDateTime = $currentDateTime->add(new DateInterval('PT' . $period . 'M'));
        $endTime = $endDateTime->format('Y-m-d H:i:s');
        $combinedPeriod = $period . ':' . $endTime;



        $sql ="INSERT INTO auctionpost (Post_no, StartPrice, BuynowPrice, Period, A_State)
        VALUES ('$last_id', '$startPrice', '$buynowPrice', '$combinedPeriod', '진행중')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "상품이 성공적으로 업로드되었습니다.";
    } else {
        echo "오류: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
        <!-- 메인 홈페이지로 돌아가기 버튼 -->
        <p><a href="main.php">메인페이지로 돌아가기</a></p>
    </div>
</body>
</html>