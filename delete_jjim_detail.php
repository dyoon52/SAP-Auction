<?php session_start(); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // 데이터베이스 연결
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $dbname = "auctiondb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("연결 실패: " . $conn->connect_error);
    }

    $user_id  = $_SESSION['userID'];
    $post_no = $_GET['post_id'];

    // 찜 삭제
    $sql = "DELETE FROM jjim WHERE Post_no = $post_no AND userID = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "찜 삭제 성공";
    } else {
        echo "찜 삭제 실패: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    header("Location: product_detail.php?product_id=" . $post_no);
}
?>