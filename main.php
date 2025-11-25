<?php
$con = mysqli_connect("localhost", "root", "1234", "auctiondb");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
include 'navbar.php';
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>중고 거래 홈페이지</title>
    <style>
        body {
            font-family: 'Noto Sans KR', sans-serif;
            margin: 0 auto;
            max-width: 1200px;
        }

        header {
            background-color: #f9f9f9;
            border-bottom: 1px solid #d3d3d3;
            display: flex;
            justify-content: flex-end;
            padding: 10px 20px;
        }

        header ul {
            display: flex;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        header li {
            margin: 0 10px;
        }

        .nav-item::before {
            content: ' ';
        }
        .nav-item:first-child::before {
            content: '';
        }

        header a {
            color: #333;
            text-decoration: none;
        }

        .category-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 50px 0;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 40px;
            text-align: center;
        }

        .category-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        button {
            background-color: #8c24ec;
            border: none;
            border-radius: 8px;
            color: #fff;
            cursor: pointer;
            font-size: 1rem;
            margin: 10px;
            padding: 15px 25px;
        }

        button:hover {
            background-color: #6a0db5;
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 40px;
        }

        .product-card {
            box-sizing: border-box;
            border: 1px solid #f0f0f0;
            border-radius: 4px;
            padding: 20px;
            width: 360px;
            margin: 20px;
            text-align: center;
            background-color: white;
        }

        .product-card img {
            max-width: 100%;
            height: auto;
        }

        .product-card h2 {
            font-size: 18px;
        }

        .product-card p {
            margin-top: 10px;
            font-size: 14px;
            color: #888;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 1.5rem;
            }

        button {
                font-size: 0.8rem;
                padding: 10px 20px;
            }

            .product-card {
                width: calc(50% - 40px);
            }
        }

        @media (max-width: 480px) {
            .product-card {
                width: 100%;
                margin: 20px 0;
            }
        }

        .banner {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
        }

        .banner img {
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .banner h2,
        .banner p {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            color: #FFF;
            text-align: center;
        }

        .banner h2 {
            font-size: 3rem;
        }

        .banner p {
            font-size: 1.5rem;
        }

        main {
            min-height: 100vh;
        }

        button.selected {
            background-color: #3d3d3d;
        }

        .arrow {
            cursor: pointer;
            font-size: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            width: 50px;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            top: 0;
            z-index: 2;
            color: #fff;
        }

        .arrow:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .arrow.prev {
            left: 0;
        }

        .arrow.next {
            right: 0;
        }



    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // DOM이 로드되면 실행
        document.addEventListener('DOMContentLoaded', function() {
            var categoryButtons = document.querySelectorAll('.category-buttons button');

            categoryButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var selectedCategory = this.getAttribute('data-category');
                    var productList = document.querySelectorAll('.product-card');

                    categoryButtons.forEach(function(removeButton) {
                    removeButton.classList.remove('selected');
                    });
                    
                    this.classList.add('selected');

                    productList.forEach(function(product) {
                        var productCategory = product.getAttribute('data-category');

                        if (selectedCategory === productCategory) {
                            product.style.display = 'block';
                        } else {
                            product.style.display = 'none';
                        }
                    });
                });
            });
        });

        // 찜하기 함수
        function addToWishlist(postId) {
            location.href = "main.php?wishlist_id=" + postId + "&action=add";
            alert("찜하였습니다!");
        }

        // 찜 제거 함수
        function removeFromWishlist(postId) {
            location.href = "main.php?wishlist_id=" + postId + "&action=remove";
            alert("찜 제거되었습니다!");
        }

        $(document).ready(function () {
            // 찜하기 및 찜 제거 이벤트 연결
            $('.wishlist-button').click(function () {
                const postId = $(this).data('post-id');
                const action = $(this).data('action');

                if (action === 'add') {
                    addToWishlist(postId);
                } else if (action === 'remove') {
                    removeFromWishlist(postId);
                }
            });
        });


         $(document).ready(function () {

        var banner = document.querySelector('.banner');
        var images = document.querySelectorAll('.banner img');
        var index = 0;
        var autoSlide;

        function handlePrev() {
            index--;
        if (index < 0) {
            index = images.length - 1;
        }
        updateImage();
        }

        function handleNext() {
            index++;
        if (index >= images.length) {
            index = 0;
        }
        updateImage();
        }

        function updateImage() {
            images.forEach(function (img) {
            img.style.display = 'none';
        });

        images[index].style.display = 'block';
        }

        function autoChangeImage() {
            clearInterval(autoSlide);
        autoSlide = setInterval(function () {
            handleNext();
        }, 5000);
        }

    // 초기 이미지 설정 및 자동 슬라이드 시작
    updateImage();
    autoChangeImage();

    $(".arrow.prev").click(function () {
        handlePrev();
        autoChangeImage();
    });

    $(".arrow.next").click(function () {
        handleNext();
        autoChangeImage();
    });
});


    </script>
</head>
<body>
    <main>
    <div class="banner">
        <img src="ad1.jpg">
        <img src="ad2.jpg" style="display: none;">
        <img src="ad3.jpg" style="display: none;">
        <div class="arrow prev" onclick="handlePrev()">&lt;</div>
        <div class="arrow next" onclick="handleNext()">&gt;</div>
    </div>
            <div class="category-buttons">
                <?php
                    // 데이터베이스 커넥션 생성
                    $con = mysqli_connect("localhost", "root", "1234", "auctiondb") or die("MySQL 연결 실패!!");

                    // 연결 확인
                    if ($con->connect_error) {
                        die("Connection failed: " . $con->connect_error);
                    }

                    // 카테고리 정보를 가져오는 쿼리문 작성
                    $sql = "SELECT * FROM category";

                    // 쿼리 실행
                    $result = $con->query($sql);

                    // 결과 출력
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<button data-category="' . $row["Category"] . '">' . $row["Category"] . '</button>';
                        }
                    } else {
                        echo "카테고리가 없습니다.";
                    }

                    // 커넥션 종료
                    $con->close();
                ?>
            </div>
            <div class="product-list">
                <?php
                    // 커넥션 생성
                    $con = mysqli_connect("localhost", "root", "1234", "auctiondb") or die("MySQL 연결 실패!!");

                    // 연결 확인
                    if ($con->connect_error) {
                        die("Connection failed: " . $con->connect_error);
                    }

                    // 쿼리문 작성
                    $sql = "SELECT * FROM post";

                    // 쿼리 실행
                    $result = $con->query($sql);

                    $user_id = isset($_SESSION['userID']) ? $_SESSION['userID'] : '';
                    $wishlist = [];
                    if (!empty($user_id)) {
                        $wishlistQuery = "SELECT * FROM jjim WHERE UserID='$user_id'";
                        $wishlistResult = mysqli_query($con, $wishlistQuery);

                        while ($wishlistRow = mysqli_fetch_assoc($wishlistResult)) {
                            $wishlist[] = $wishlistRow['Post_no'];
                        }
                    }
                    // 결과 출력
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="product-card" data-category="' . $row["Category"] . '">';
                            echo '<img src="data:image/jpeg;base64,'.base64_encode($row['PostImg']).'" alt="' . $row["PostTitle"] . '"/>';
                            echo '<h2>' . $row["PostTitle"] . '</h2>';

                            // 판매 방식 표시 조건문 추가
                            if ($row["SellType"] == "normal") {
                                echo '<p>판매 방식: 일반 상품</p>';
                            } elseif ($row["SellType"] == "auction") {
                                echo '<p>판매 방식: 경매 상품</p>';
                            }

                            echo '<p>카테고리: ' . $row["Category"] . '</p>';
                            echo '<button onclick="location.href=\'product_detail.php?product_id=' . $row["Post_no"] . '\'" class="details-button">자세히 보기</button>';

                            if (isset($_SESSION['userID'])) {
                                if (in_array($row["Post_no"], $wishlist)) {
                                    echo '<button class="wishlist-button" data-action="remove" data-post-id="' . $row["Post_no"] . '">찜 제거하기</button>';
                                } else {
                                    echo '<button class="wishlist-button" data-action="add" data-post-id="' . $row["Post_no"] . '">찜하기</button>';
                                }
                            }

                            echo '</div>';
                        }
                    } else {
                        echo "상품이 없습니다.";
                    }

                    // 커넥션 종료
                    $con->close();
                ?>
            </div>
    </main>
</body>
</html>