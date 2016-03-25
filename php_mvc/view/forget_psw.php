<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>找回密碼</title>
	<script type="text/javascript">
		function chk_form(){
			var email = document.getElementById("email");
			if(email.value==""){
				alert("Email不能為空！");
				return false;
			}
			var preg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; 
			if(!preg.test(email.value)){ 
				alert("Email格式錯誤！");
				return false;
			}
		}
	</script>
</head>

<body>
	<p>請輸入您的信箱，找回密碼</p>
	<form method="POST" action="?action=forgetPswAction" onsubmit="return chk_form();">
		<input type="text" class="input" name="email" id="email">
		<button>送出</button>
	</form>
	<a href="?action=login">回登入頁</a>&nbsp;&nbsp;
	<a href="?action=register">註冊</a>	
</body>
</html>