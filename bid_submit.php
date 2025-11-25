<?php session_start(); ?>
<?php if (isset($_SESSION["userID"])) { ?>
<?php
$userID = $_SESSION['userID'];

$servername = "localhost";
$username = "root";
$password = "xoo38699";
$dbname = "auctiondb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// URL 매개변수로부터 상품 ID, 사용자 ID, 제시한 가격 가져오기
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
$bid_price = isset($_GET['bid_price']) ? intval($_GET['bid_price']) : 0;

// 경매 상품의 현재 HighPrice 값 가져오기
$sql = "SELECT HighPrice FROM auctionpost WHERE Post_no = $post_id";
$result = $conn->query($sql);
$current_high_price = $result->fetch_assoc()["HighPrice"];

// 제시한 가격이 현재 HighPrice 보다 높은지 확인
if ($bid_price <= $current_high_price) {
    ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>높은 가격 제시</title>
        </head>

        <body>
            <p>더 높은 가격을 제시해주세요.</p>
            <p id="countdown">3 초 뒤에 이전으로 돌아갑니다.</p>

            <script>
    let seconds = 3;
    function countdown() {
        document.getElementById("countdown").innerHTML = seconds + " 초 뒤에 이전으로 돌아갑니다.";
        seconds--;

        if (seconds < 0) {
            window.location.href = "product_detail.php?product_id=<?= $post_id ?>";
        } else {
            setTimeout(countdown, 1000);
        }
    }

    countdown();
</script>

        </body>

        </html>

    <?php
} else {
    // 경매 상품 정보 업데이트
    $sql = "UPDATE auctionpost SET HighPrice = $bid_price, highuser = '$userID', Bid_Count = Bid_Count + 1 WHERE Post_no = $post_id";

    if ($conn->query($sql) === TRUE) {
        echo "경매 정보가 성공적으로 업트되었습니다.";
        header("Location: product_detail.php?product_id=$post_id");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<?php } ?>
