<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>註冊帳號</title>
	<script type="text/javascript">
		function chk_form(){
			var email = document.getElementById("email");
			if(email.value==""){
				alert("Email不能為空！");
				return false;
			}
			var pass = document.getElementById("pass");
			if(pass.value==""){
				alert("密碼不能為空！");
				return false;
			}
			var preg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; //匹配Email
			if(!preg.test(email.value)){ 
				alert("Email格式錯誤！");
				return false;
			}
		}
	</script>
</head>

<body>
	<form method="POST" action="?action=registerAction" onsubmit="return chk_form();">
		E-mail：<input type="text" class="input" name="email" id="email"><br/><br/>
		密　碼：<input type="password" class="input" name="psw" id="pass"><br /> <br />
		<button>註冊</button>
		<a href="?action=login">回登入頁</a>&nbsp;&nbsp;
		<a href="?action=forgetPsw">忘記密碼?</a>
	</form>
</body>
</html>