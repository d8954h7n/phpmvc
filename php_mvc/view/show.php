<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>資料一覽</title>
</head>
<body>
	<button onclick="location.href='?action=insert'">新增資料</button>
	<br /><br />
	<table border="1" width="50%">
		<tr align="center">
			<td>學制</td>
			<td>科系</td>
			<td>班級</td>
			<td>學號</td>
			<td>姓名</td>
			<td>修改</td>
			<td>刪除</td>
		</tr>
		<?php foreach($sql as $show) { ?>
		<tr>
			<td><?php echo $show['educational_system'];?></td>
			<td><?php echo $show['department'];?></td>
			<td><?php echo $show['class'];?></td>
			<td><?php echo $show['num'];?></td>
			<td><?php echo $show['name'];?></td>
			<td align="center">
				<form action="?action=update" method="POST">
					<input type="text" name="no" value="<?php echo $show['no']; ?>" hidden>
					<button>修改</button>
				</form>
			</td>
			<td align="center">
				<form action="?action=delete" method="POST">
					<input type="text" name="no" value="<?php echo $show['no']; ?>" hidden>
					<button onclick="return confirm('確認刪除?')">刪除</button>
				</form>
			</td>
		</tr>
		<?php } ?>
	</table>
</body>
</html>