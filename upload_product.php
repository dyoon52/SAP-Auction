<!DOCTYPE html>
<html>
<head>
  <title>제품 업로드</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      padding: 20px;
      max-width: 800px;
      margin: auto;
      color: #333333;
    }

    h1 {     font-size: 2em;
      text-align: center;
      margin-bottom: 20px;
    }

    form {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    label {
      font-weight: bold;
      display: block;
      margin: 10px;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #cccccc;
      border-radius: 4px;
      font-size: 14px;
      color: #333333;
    }

    #postImg {
      padding: 0;
      margin-top:10px;
    }

    input[type="radio"], input[type="radio"] + label {
      display: inline-block;
      width: initial;
      margin-top: 15px;
      margin-bottom: 5px;
    }        

    input[type="submit"] {
      background-color: #3366FF;
      color: white;
      padding: 15px;
      margin-top: 10px;
      font-size: 14px;
      font-weight:bold;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      display:block;
      width:100%;
      margin-bottom: 5px;
    }

    input[type="submit"]:hover {
      background-color: #5385FF;
    }

    .button-container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100px;
}

    .back-to-main {
  display: inline-block;
  background-color: #1abc9c;
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  padding: 10px 20px;
  font-size: 16px;
  margin: 10px 2px;
  cursor: pointer;
  border-radius: 4px;
}
.back-to-main:hover {
  background-color: #16a085}

  </style>
</head>
<body>
  <?php session_start(); ?>
  <h1>제품 업로드</h1>
  <form action="upload_product_result.php" method="POST" enctype="multipart/form-data">
    <?php
      if (isset($_SESSION['userID'])) {
        echo '<input type="hidden" id="userID" name="userID" value="'.$_SESSION['userID'].'">';
      } else {
        echo '로그인이 필요합니다.<br>';
      }
    ?>
    <label for="postTitle">제품 이름:</label>
    <input type="text" id="postTitle" name="Title" required><br>
    <label for="content">제품 설명:</label>
    <textarea id="content" name="content" required></textarea><br>
    <label for="category">카테고리:</label>
    <select id="category" name="category" required>
          <option value="">카테고리 선택</option>
          <option value="가구/인테리어">가구/인테리어</option>
          <option value="게임/취미">게임/취미</option>
          <option value="기타 중고물품">기타 중고물품</option>
          <option value="남성의류/잡화">남성의류/잡화</option>
          <option value="도서/티켓/음반">도서/티켓/음반</option>
          <option value="동물용품">동물용품</option>
          <option value="디지털/가전">디지털/가전</option>
          <option value="생활/가공식품">생활/가공식품</option>
          <option value="스포츠/레저">스포츠/레저</option>
          <option value="아동/유아용품">아동/유아용품</option>
          <option value="여성의류/잡화">여성의류/잡화</option>
      </select><br>
    <label for="postImg">제품 이미지:</label>
    <input type="file" id="postImg" name="postImg" required><br>
    <p>판매 유형:</p>

    <form action="upload_product_result.php" method="POST" enctype="multipart/form-data">

    <input type="radio" id="sellTypeNormal" name="sellType" value="normal" checked>
    <label for="sellTypeNormal">일반 상품</label><br>
    <input type="radio" id="sellTypeAuction" name="sellType" value="auction" required>
    <label for="sellTypeAuction">경매 상품</label><br>
    
    <!-- 일반 상품 정보 -->
    <div id="normalProductDetails" style="display:block;">
      <label for="price">가격:</label>
      <input type="number" id="price" name="price" required><br>
      <label for="nState">일반 상품 상태:</label>
      <input type="text" id="nState" name="nState" required><br>
    </div>

    <!-- 경매 상품 정보 -->
    <div id="auctionDetails" style="display:none;">
      <label for="startPrice">시작 가격</label>
      <input type="number" id="startPrice" name="startPrice"><br>
      <label for="buynowPrice">즉시 구매 가격:</label>
      <input type="number" id="buynowPrice" name="buynowPrice"><br>
      <label for="period">경매 기간: (일)</label>
      <input type="number" id="period" name="period"><br>
    </div>
    <input type="submit" value="제품 업로드">

    <div class="button-container">
  <a href="main.php" class="back-to-main">메인 페이지로 이동</a>
  </div>
  

  </form>
  
  <script>
        document.getElementById("sellTypeAuction").addEventListener("change", function() {
      document.getElementById("auctionDetails").style.display = "block";
      document.getElementById("normalProductDetails").style.display = "none";
      document.getElementById("price").required = false;
      document.getElementById("nState").required = false;
    });

    document.getElementById("sellTypeNormal").addEventListener("change", function() {
      document.getElementById("auctionDetails").style.display = "none";
      document.getElementById("normalProductDetails").style.display = "block";
      document.getElementById("price").required = true;
      document.getElementById("nState").required = true;
    });
  </script>
</body>
</html>