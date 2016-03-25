<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>登入</title>
</head>
<body>
	<form method="POST" action="?action=loginAction">
		E-mail：<input name="email" type="text" placeholder="請輸入信箱" /><br /> <br />
		密碼：<input name="psw" type="password" placeholder="請輸入密碼" /><br /> <br />
		<button>登入</button>
		<a href="?action=register">註冊</a>&nbsp;&nbsp;
		<a href="?action=forgetPsw">忘記密碼</a>		
	</form>
</body>
</html>