<?php
session_start();

// 데이터베이스 연결
$servername = "localhost";
$username = "root";
$password = "xoo38699";
$dbname = "auctiondb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

// 사용자의 찜 목록 가져오기
$user_id = $_SESSION['userID'];
$sql = "SELECT post.* FROM post JOIN jjim ON post.Post_no = jjim.Post_no WHERE jjim.UserID = '$user_id'";
$result = mysqli_query($conn, $sql);
$jjimList = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($jjimList, $row);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<head>
    <title>사용자 찜 목록</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 50px 0;
        }
        
        .wishlist-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            width: 100%;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            margin-bottom: 20px;
            font-size: 26px;
            font-weight: bold;
        }

        .table {
            margin-bottom: 20px;
        }
        
        .delete-btn {
            background-color: transparent;
            border: none;
            color: #f14668;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            padding: 0;
            display: inline;
        }

        .delete-btn:hover {
            color: #d63384;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            padding:20px;
            border-radius: 10px;
            text-align: center;
        }

        #backButton {
    display: inline-block;
    background-color: #4caf50; /* 버튼의 배경색 */
    border: none;
    color: white; /* 글자색 */
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    padding: 8px 16px; /* 상하 여백 8px, 좌우 여백 16px */
    border-radius: 4px; /* 모서리 둥글게 */
    cursor: pointer;
    transition: all 0.3s; /* 클릭 이펙트 애니메이션 시간 */
  }

  #backButton:hover {
    background: #45a049; /* 마우스 오버 시 배경색 변경 */
  }
    </style>
    <script>
        function deleteJjim(postNo) {
            const userId = '<?php echo $user_id; ?>';
            const data = new FormData();
            data.append('Post_no', postNo);
            data.append('userID', userId);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_jjim.php', true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    alert('찜이 삭제되었습니다.');
                    location.reload();
                }
            };

            xhr.send(data);
        }
    </script>
</head>
<body>
<div id="popup" class="popup">
    해당 사용자의 찜 목록이 없습니다.
    <br>
    <button onclick="closePopup()" class="button is-primary">확인</button>
</div>

<script>
    let jjimList = <?php echo json_encode($jjimList); ?>;
    
    if (jjimList.length === 0) {
        let popup = document.getElementById('popup');
        popup.style.display = 'block';
    }

    function closePopup() {
        let popup = document.getElementById('popup');
        popup.style.display = 'none';
    }
</script>

<div class="wishlist-container">
<h1 class="title">사용자 찜 목록</h1>
<table class="table is-bordered is-striped is-hoverable is-fullwidth">
    <thead>
        <tr>
           <th>게시물 번호</th>
           <th>이미지</th>
           <th>제목</th>
           <th>내용</th>
           <th>카테고리</th>
         </tr>
    </thead>
    <tbody>

        <?php
        foreach ($jjimList as $item) {
            $imageData = base64_encode($item['PostImg']);
            echo "<tr>
                <td>{$item['Post_no']}</td>
                <td><img src='data:image/jpeg;base64,{$imageData}' alt='이미지' width='100' height='100'></td>
                <td>{$item['PostTitle']}</td>
                <td>{$item['content']}</td>
                <td>{$item['Category']}</td>
                <td><button onclick='deleteJjim(\"{$item['Post_no']}\")' class='button is-small is-danger'>찜 삭제</button></td>
           </tr>";
        }
        ?>
        </tbody>
    </table>
    <div class="is-flex is-justify-content-center" style="margin-bottom: 15px;">
    <button id="backButton" onclick="location.href='main.php'">메인페이지 돌아가기</button>
</div>
    </body>
</html>
