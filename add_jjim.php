<?php
session_start();
if (isset($_SESSION["userID"])) {
    $con = mysqli_connect("localhost", "root", "1234", "auctiondb");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }

    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
    $userId = $_SESSION['userID'];

    $sql = "INSERT INTO jjim (UserID, Post_no) VALUES ('$userId', '$post_id')";
    mysqli_query($con, $sql);
    
    mysqli_close($con);

    header("Location: product_detail.php?product_id=$post_id");
} else {
    header('Location: main.php');
    exit;
}
?>
