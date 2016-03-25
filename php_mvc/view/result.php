<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>跳轉頁面</title>
</head>

<body>
	<script>alert("<?php echo $msg; ?>");</script>
	<?php 
	header("refresh:0;$link");
	?>
</body>
</html>