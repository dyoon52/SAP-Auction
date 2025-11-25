<?php
session_start();

if (!isset($_POST['delete_product'])) {
    header('Location: main.php');
    exit();
}

if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit();
}

$userID = $_SESSION['userID'];
$post_no = $_POST['post_no'];

// 데이터베이스 연결
$con = mysqli_connect("localhost", "root", "1234", "auctiondb") or die("MySQL 연결 실패!");

// 연결 확인
if ($con->connect_error)     die("Connection failed: " . $con->connect_error);


// jjim 테이블에서 연관된 레코드를 먼저 삭제
$sql_delete_jjim = "DELETE FROM jjim WHERE Post_no = '$post_no'";
if ($con->query($sql_delete_jjim) === true) {
    // auctionpost 테이블에서 레코드를 삭제
    $sql = "DELETE FROM auctionpost WHERE Post_no = '$post_no'";
    
    if ($con->query($sql) === true) {
        // normalprod 테이블에서 연관된 레코드를 삭제
        $sql_delete_normalprod = "DELETE FROM normalprod WHERE Post_no = '$post_no'";
        
        if ($con->query($sql_delete_normalprod) === true) {
            // post 테이블에서 레코드를 삭제
            $sql_delete_post = "DELETE FROM post WHERE Post_no = '$post_no' AND userID = '$userID'";

            if ($con->query($sql_delete_post) === true) {
                header('Location: myproduct.php');
            } else {
                echo "Error: " . $sql_delete_post . "<br>" . $con->error;
            }
        } else {
            echo "Error: " . $sql_delete_normalprod . "<br>" . $con->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

} else {
    echo "Error: " .sql_delete_jjim . "<br>" . $con->error;
}

// 커넥션 종료
$con->close();
?>