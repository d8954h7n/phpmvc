<?php
require("db_connection.php");
require("model/model.php");
if(isset($_GET['action'])){

	$model = new model($dbh);

	function getinfo() {
		$es = $_POST['es'];
		$dep = $_POST['dep'];
		$cls = $_POST['cls'];
		$num = $_POST['num'];
		$name = $_POST['name'];
		return array($es, $dep, $cls, $num, $name);
	}

	$urlError = "請重新確認網址";
	$link = "index.php?action=show";

	switch ($_GET['action']) {
		case 'show':
			$prepareSQL = "SELECT * FROM student";
			$executeSQL = array();
			$sql = $model->getDataSQL($prepareSQL, $executeSQL);
			require("view/show.php");
			break;

		case 'insert':
			require("view/insert.php");
			break;

		case 'insert_fin':
			list($es, $dep, $cls, $num, $name) = getinfo();
			if(!is_null($es) && !is_null($dep) && !is_null($cls) && !is_null($num) && !is_null($name)) {
				$prepareSQL = "INSERT INTO student(educational_system, department, class, num, name) VALUES(:es, :dep, :cls, :num, :name)";
				$executeSQL = array(':es' => $es, ':dep' => $dep, ':cls' => $cls, ':num' => $num, ':name' => $name);
				$result =  $model->rowCountSQL($prepareSQL, $executeSQL);
				if($result == 1) {
					$msg = "新增成功!";
				}
				else {
					$msg = "新增失敗!";
				}
			}
			else {
				$msg = $urlError;
			}
			require("view/result.php");
			break;

		case 'update':
				$no = $_POST['no'];
				if(!is_null($no)) {
				$prepareSQL = "SELECT * FROM student WHERE no = :no";
				$executeSQL = array(':no' => $no);
				$result = $model->getDataSQL($prepareSQL, $executeSQL);
			}
			else {
				$msg = $urlError;
			}
			require("view/update.php");
			break;

		case 'update_fin':
			$no = $_POST['no'];
			if(!is_null($no)) {
				list($es, $dep, $cls, $num, $name) = getinfo();
				$prepareSQL = "UPDATE student SET educational_system = :es, department = :dep, class = :cls, num = :num, name = :name WHERE no = :no";
				$executeSQL = array('es' => $es, ':dep' => $dep, ':cls' => $cls, ':num' => $num, ':name' => $name, ':no' => $no);
				$result =  $model->rowCountSQL($prepareSQL, $executeSQL);
				if($result == 1) {
					$msg = "修改成功!";
				}
				else {
					$msg = "修改失敗!";
				}
			}
			else {
				$msg = $urlError;
			}
			require("view/result.php");
			break;

		case 'delete':
			$no = $_POST['no'];
			if(!is_null($no)) {
				$prepareSQL = "DELETE FROM student WHERE no = :no";
				$executeSQL = array(':no' => $no);
				$result =  $model->rowCountSQL($prepareSQL, $executeSQL);
				if($result == 1) {
					$msg = "刪除成功!";
				}
				else {
					$msg = "刪除失敗!";
				}
			}
			else {
				$msg = $urlError;
			}
			require("view/result.php");
			break;

		default:
			require("view/error.php");
			break;
	}
}
else{
	require("view/error.php"); //哈哈哈
}