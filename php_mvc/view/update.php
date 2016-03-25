<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>修改</title>
</head>
<body>
	<button onclick="location.href='?action=show'">回首頁</button>
	<br /><br />
	<form action="?action=update_fin" method="POST">
		<?php foreach($result as $row) { ?>
		<input type="text" name="no" value="<?php echo $row['no'] ?>" hidden/>
		學制：<input type="text" name="es" value="<?php echo $row['educational_system'] ?>" />
		<br /> <br />
		科系：<input type="text" name="dep" value="<?php echo $row['department'] ?>" />
		<br /> <br />
		班級：<input type="text" name="cls" value="<?php echo $row['class'] ?>" />
		<br /> <br />
		學號：<input type="text" name="num" value="<?php echo $row['num'] ?>" />
		<br /> <br />
		姓名：<input type="text" name="name" value="<?php echo $row['name'] ?>" />
		<br /> <br />
		<?php } ?>
		<br />
		<button onclick="return confirm('確認修改?')">修改</button>
	</form>
</body>
</html>