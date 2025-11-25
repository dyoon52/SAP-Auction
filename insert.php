<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입 페이지</title>
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
            text-decoration: underline;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        
        .register-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            margin-bottom: 20px;
            font-size: 26px;
            font-weight: bold;
        }
        label {
            display: block;
            font-size: 14px;
            margin: 5px 0;
        }
        input[type="text"], input[type="password"], input[type="tel"], input[type="email"] {
            width: 100%;
            padding: 5px;
            margin: 5px 0;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .address-group {
            display: flex;
            justify-content: space-between;
        }
        .address-group input[type="text"] {
            flex: 1;
            margin: 5px;
        }
        button[type="submit"] {
            width: 100%;
            padding: 5px;
            margin-top: 20px;
            background-color: #007BFF;
            border-color: #007BFF;
            color: white;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }
        .info-text {
            font-size: 12px ;           
            color: #888;
            margin-top: 3px;
        }
    </style>
    <script>
        function onlyNumberInput(e) {
            var keyCode = e.keyCode ? e.keyCode : e.which;
            if ((keyCode < 48 || keyCode > 57) && keyCode !== 8) {
                return false;
            }
        }
    </script>
</head>
<body>
    <div class="register-container">
        <h1>회원가입</h1>
        <form action="insert_result.php" method="post">
    <label for="name">이름</label>
    <input type="text" id="name" name="userName" required />
    <label for="userid">아이디</label>
    <input type="text" id="userid" name="userID" required />
    <label for="password">비밀번호</label>
    <input type="password" id="password" name="userPW" required />
    <label for="phone">전화번호</label>
    <input type="tel" id="phone" name="phoneNum" placeholder="( - )없이 숫자만 입력해주세요" onkeypress="return onlyNumberInput(event)" required />
    <label for="email">이메일</label>
    <input type="email" id="email" name="userMail" required />
    <label for="address">주소</label>
    <div class="address-group">
        <input type="text" id="userAddr" name="userAddr" placeholder="주소" required />
        <input type="text" id="detailAddress" name="detail_Addr" placeholder="상세주소" required />
    </div>
    <button type="submit">회원가입</button>
</form>

    
</body>
</html>
