<?php
session_start();

// 변경 후
if (!($_SESSION['userID'])) {
    header('Location: login.php');
     exit();
 }

$userID = $_SESSION['userID'];

// 데이터베이스 연결
$con = mysqli_connect("localhost", "root", "1234", "auctiondb") or die("MySQL 연결 실패!");

// 연결 확인
if ($con->connect_error)  {
    die("Connection failed: " . $con->connect_error);
}

$sql = "SELECT * FROM post WHERE userID = '$userID'";

// 쿼리 실행
if (!($result = $con->query($sql))) {
    printf("Error: %s\n", $con->connect_error);
    exit();
}
?>

<!DOCTYPE post html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>나의 상품</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #35424a;
            color: #ffffff;
            padding: 15px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            overflow: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            margin-bottom: 16px;
        }

        th, td {
            padding: 5px;
            border: 1px solid #dddddd;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            color: #35424a;
            text-decoration: none;
        }

        a:hover {
            color: #474e5d;
        }

        .product-img {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
    <h1>나의 상품</h1>
 <div class="container">
        <table>
            <thead>
                <tr>
                    <th>게시물 번호</th>
                    <th>이미지</th>
                    <th>게시물 제목</th>
                    <th>판매 유형</th>
                    <th>상세 정보</th>
                </tr>
            </thead>
            <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imageData = base64_encode($row['PostImg']);
                echo '<tr>
                    <td>' . $row["Post_no"] . '</td>
                    <td><img src="data:image/jpeg;base64,' . $imageData . '" alt="이미지" width="100" height="100"></td>
                    <td>' . $row["PostTitle"] . '</td>
                    <td>' . $row["SellType"] . '</td>
                    <td><a href="product_detail.php?post_no=' . $row["Post_no"] . '">상세 보기</a></td>
                    <td><form action="delete_product.php" method="post">
                        <input type="hidden" name="post_no" value="' . $row["Post_no"] . '">
                        <button type="submit" name="delete_product">판매 중단</button>
                    </form></td>
                </tr>';
            }
        } else {
            echo '<tr><td colspan="5">등록된 상품이 없습니다.</td></tr>';
        }
        ?>
    </tbody>
        </table>
        <a href="main.php">메인 페이지로 돌아가기</a>
    </div>
    <?php
    // 커넥션 종료
    $con->close();
    ?>
</body>
</html>