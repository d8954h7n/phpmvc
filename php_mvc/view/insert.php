<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>新增資料</title>
</head>
<body>
	<button onclick="location.href='?action=show'">回首頁</button>
	<br /><br />
	<form action="?action=insert_fin" method="POST">
		學制 <input name="es" /><br /><br />
		科系 <input name="dep" /><br /><br />
		班級 <input name="cls" /><br /><br />
		學號 <input name="num" /><br /><br />
		姓名 <input name="name" /><br /><br />
		<button>送出</button>
	</form>
</body>
</html>
