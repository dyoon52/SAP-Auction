<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>로그인 페이지</title> 
        <style> * 
        { box-sizing: border-box; margin: 0; padding: 0; } 
        a { color: #007BFF; text-decoration: none; } 
        a:hover { text-decoration: underline; }
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f2f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        text-align: center;
    }
    
    .login-container {
        background-color: white;
        padding: 100px;
        border-radius: 8px;
        width: 500px;
        box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
    }
    
    h1 {
        margin-bottom: 20px;
        font-size: 26px;
        font-weight: bold;
    }
    
    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 5px;
        margin: 10px 0;
        border: 2px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
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

</style>
</head>
<body>
    <div class="login-container">
        <h1>로그인</h1>
        <form action="login_result.php" method="post">
            <label for="userid">아이디</label>
            <input type="text" id="userid" name="userID" required>
            <label for="password">비밀번호</label>
            <input type="password" id="password" name="userPW" required>
            <button type="submit">로그인</button>
        </form>
        <p>아직 회원이 아니신가요? <a href="insert.php">회원가입</a></p>
    </div>
</body>
</html>