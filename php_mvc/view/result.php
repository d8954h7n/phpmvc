<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>跳轉頁面</title>
</head>

<body>
	<script>alert("<?php echo $msg; ?>");</script> <!--- $msg是其他頁面傳來的訊息 -->
	<?php 
	header("refresh:0;$link"); 				// $link是其他頁面傳來的網址
	?>
</body>
</html>