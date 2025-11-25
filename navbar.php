<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ko">
<head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
    }

    .logo {
        margin-right: auto;
    }

    .logo img {
        height: 5em; /* 로고 이미지 높이를 1.2em으로 설정 (글자 크기를 기준으로) */
        width: auto; /* 로고 이미지 너비를 자동으로 설정 (높이와 비율을 유지하면서) */
    }

    .navbar {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 100;
        background-color: #f9f9f9;
        border-bottom: 1px solid #d3dd3;
        display: flex;
        justify-content: flex-end; 
        padding: 15px; 20px;
    }

    .navbar ul {
        display: flex;
        justify-content: flex-end;
        list-style-type: none;
    }

    .nav-item {
        margin-left: 1.5rem;
    }

    .nav-item a {
        color: black;
        text-decoration: none;
        font-weight: bold;
        font-size: 16px;
    }

    .nav-item a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>
 <nav class="navbar">
    <a href="main.php" class="logo">
        <img src="logo.jpg" alt="로고" />
    </a>

    <ul>
            <?php
// 찜하기/찜 제거 이벤트 처리
if (isset($_GET['wishlist_id']) && isset($_GET['action']) && isset($_SESSION['userID'])) {
    $postId = mysqli_real_escape_string($con, $_GET['wishlist_id']);
    $userId = $_SESSION['userID'];
    $action = $_GET['action'];

    if ($action == 'add') {
        $addWishlistQuery = "INSERT INTO jjim (UserID, Post_no) VALUES ('$userId', '$postId')";
        mysqli_query($con, $addWishlistQuery);
    } elseif ($action == 'remove') {
        $removeWishlistQuery = "DELETE FROM jjim WHERE UserID='$userId' AND Post_no='$postId'";
        mysqli_query($con, $removeWishlistQuery);
    }
}
?>
<?php if (isset($_SESSION["userID"])): ?>
    <?php
        // 세션에 저장된 userID 값 가져오기
        $userID = $_SESSION['userID'];

        // 커넥션 생성
        $con = mysqli_connect("localhost", "root", "1234", "auctiondb") or die("MySQL 연결 실패!!");

        // 연결 확인
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        // 쿼리문 작성
        $sql = "SELECT UserName FROM usertbl WHERE UserID = '".$userID."'";

        // 쿼리 실행
        $result = $con->query($sql);

        // 결과 출력
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<li class="nav-item"><a href="member_info.php">'. $row["UserName"] . '님</a></li>';
            }
        } else {
            echo "0 results";
        }

        // 커넥션 종료
        $con->close();
    ?>
    <li class="nav-item"><a href="wishlist.php">찜 목록</a></li>
    <li class="nav-item"><a href="upload_product.php">상품 등록</a></li>
    <li class="nav-item"><a href="myproduct.php">나의 상품</a></li>
    <li class="nav-item"><a href="logout.php">로그아웃</a></li>
<?php else: ?>
    <li class="nav-item"><a href="login.php">로그인</a></li>
    <li class="nav-item"><a href="insert.php">회원가입</a></li>
                <?php endif; ?>
            </ul>
</nav>
</body>
</html>