<?php
include 'navbar.php';
$con = mysqli_connect("localhost", "root", "1234", "auctiondb");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// 데이터베이스 연결
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "auctiondb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 상품 ID를 URL 매개에서 가져
$post_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;


// 상품 정보오는 쿼리
$sql = "SELECT p.*, n.Price as n_price, a.* 
        FROM post p
 LEFT JOIN normalprod n ON p.Post_no = n.Post_no
        LEFT JOIN auctionpost a ON p.Post_no = a.Post_no
        WHERE p.Post_no = {$post_id}";

$result = $conn->query($sql);

// 서버에서 전달된 userID값을 받아옵니다.
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;



if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $check_jjim_sql = "SELECT * FROM jjim WHERE Post_no = {$post_id} AND UserID = '{$userId}'";
    $check_jjim_result = $conn->query($check_jjim_sql);
    $is_jjim = false;
    
    if ($check_jjim_result->num_rows > 0) {
        $is_jjim = true;
    }


    ?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>상품 상세 페이지</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 1em;
        }
        
        h1 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 0.5em;
        }
        
        img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 0 auto;
            border: 1px solid #ddd;
        }
        
        p {
            font-size: 1em;
            line-height: 1.5;
            margin-bottom: 0.75em;
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
    </style>
    <script>
function openBidPopup() {
    var bidPrice = prompt("제시할 가격 입력하세요:");

    if (bidPrice === null) return;

    if (!isNaN(bidPrice)) {
        window.location.href = 'bid_submit.php?post_id=<?php echo $post_id; ?>&user_id=<?php echo $userId; ?>&bid_price=' + bidPrice;
    } else {
        alert("가격은 숫자로만 입력해주세요.");
    }
}

</script>
</head>
<body>
        
        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['PostImg']); ?>" alt="<?php echo $row['PostTitle']; ?>"/>
        <p>제품명: <?php echo $row['PostTitle']; ?></p>
        <p>카테고리: <?php echo $row['Category']; ?></p>
        <p>상품 설명:</p>
        <p><?php echo nl2br($row['content']); ?></p>


    <?php
    //매 방식시
    if ($row["SellType"] == "normal") {
        echo "<p>판매 방식: 일반 상품</p>";
        echo "<p>가격: " . $row['n_price'] . " 원</p>";
        ?>
        <div>
        <button class="button" onclick="alert('구매하기 기능은 아 구현되어 있지 않습니다.')">구매하기</button>
        <button class="button" onclick="window.location.href='add_jjim.php?userId=<?php echo $userId; ?>&post_id=<?php echo $post_id; ?>'">찜하기</button>
        
    <button class="button" onclick="window.location.href='delete_jjim_detail.php?userId=<?php echo $userId; ?>&post_id=<?php echo $post_id; ?>'">찜제거하기</button>

   <!-- 메인 화면으로 가기 버튼 -->
    <button class="button" onclick="window.location.href='main.php'">메인 화면으로</button>

    </div>
        <?php
    } elseif ($row["SellType"] == "auction") {
        echo "<p>판매 방식: 경매 상품</p>";
        echo "<p>시작 가격: " . $row['StartPrice'] . " 원</p>";
        echo "<p>즉시 구매 가격: " . $row['BuynowPrice'] . " 원</p>";
        echo "<p>현재 가격: " . $row['HighPrice'] . " 원</p>";
// 기존 Period 값에서 분과 종료 시간 분리
list($period, $endHour) = explode(':', $row['Period']);
$now = new DateTime();
$registeredTime = DateTime::createFromFormat('Y-m-d H:i:s', $endHour . ':00:00');
$endDateTime = clone $registeredTime;
$endDateTime->modify('+' . $period . ' day');

if ($now <= $endDateTime) {
    $timeLeft = $now->diff($endDateTime);
    $timeLeftStr = $timeLeft->format('%a일 %h시간 %i분 %s초'); // 초를 포함하도록 수정
    echo "<p>판매 기간: " . $timeLeftStr . " 남았습니다.</p>";
}  else {
    echo "<p>경매 기간이 종료되었습니다.</p>";
    $sql_delete_jjim = "DELETE FROM jjim WHERE Post_no = '$post_id'";
    if ($conn->query($sql_delete_jjim) === TRUE) {
        // auctionpost 테이블에서 레코드를 삭제
        $sql_delete_auctionpost = "DELETE FROM auctionpost WHERE Post_no = '$post_id'";
        
        if ($conn->query($sql_delete_auctionpost) === TRUE) {
            // normalprod 테이블에서 연관된 레코드를 삭제
            $sql_delete_normalprod = "DELETE FROM normalprod WHERE Post_no = '$post_id'";

            if ($conn->query($sql_delete_normalprod) === TRUE) {
                // post 테이블에서 레코드를 삭제
                $sql_delete_post = "DELETE FROM post WHERE Post_no = '$post_id'";

                if ($conn->query($sql_delete_post) === TRUE) {
                    echo "상품이 정상적으로 삭제되었습니다.";
                } else {
                    echo "Error: " . $sql_delete_post . "<br>" . $conn->error;
                }
            } else {
                echo "Error: " . $sql_delete_normalprod . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql_delete_auctionpost . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql_delete_jjim . "<br>" . $conn->error;
    }
}



        echo "<p>입찰 수: " . $row['Bid_Count'] . "</p>";
        echo "<p>경매 상태: " . $row['A_State'] . "</p>";
    ?>
    <div>
    <button class="button" onclick="alert('시 구매하기 기능은 아직 구현되어 있지 않습니다.')">즉시 구매하기</button>
    <button class="button" onclick="openBidPopup();">가격 제시하기</button>
    
    
    <!-- 메인 화면으로 가기 버튼 -->
    <button class="button" onclick="window.location.href='main.php'">메인 화면으로</button>
 
        
    <button class="button" onclick="window.location.href='add_jjim.php?userId=<?php echo $userId; ?>&post_id=<?php echo $post_id; ?>'">찜하기</button>
        
    <button class="button" onclick="window.location.href='delete_jjim_detail.php?userId=<?php echo $userId; ?>&post_id=<?php echo $post_id; ?>'">찜제거하기</button>
        
        
        
        


</div>
    <?php } ?>

</body>
</html>
    <?php
} else    echo "상품을 찾을 수 없습니다.";


$conn->close();
?>