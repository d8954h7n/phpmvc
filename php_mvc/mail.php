<?php
require("db_connection.php");
require("model/model.php");
if(isset($_GET['action'])){

	$model = new model($dbh);

	switch ($_GET['action']) {
		case 'login':
		 	require("view/login.php");
		 	break;

		case 'loginAction':
			$email = stripslashes(trim($_POST['email']));
			$psw = stripslashes(trim($_POST['psw']));

			//驗證信箱
			$prepareSQL = "SELECT * FROM member WHERE email = :email";
			$executeSQL = array(':email' => $email);
			$rowCount = $model->rowCountSQL($prepareSQL, $executeSQL);

			if($rowCount == 1) {	//判斷信箱是否存在
				$row = $model->rowDataSQL($prepareSQL, $executeSQL);	//取資料的SQL
				if(password_verify($psw, $row['psw'])) {	//驗證密碼是否相符
					$_SESSION['sid'] = $row['no'];	//將編號倒入SESSION
					$msg = "登入成功!";
					$link = "index.php?action=show";
				}
				else {
					$msg = "登入失敗!";
					$link = "mail.php?action=login";
				}
			}
			else {
				$msg = "登入失敗!";
				$link = "mail.php?action=login";
			}
			require("view/result.php");		
			break;			

		case 'register':
			require("view/register.php");	
			break;

		case 'registerAction':
			$email = stripslashes(trim($_POST['email']));
			$psw = stripslashes(trim($_POST['psw']));

			//驗證信箱
			$prepareSQL = "SELECT * FROM member WHERE email = :email";
			$executeSQL = array(':email' => $email);
			$rowCount = $model->rowCountSQL($prepareSQL, $executeSQL);

			if($rowCount == 1) {	//判斷信箱是否存在
				$msg = "該信箱已註冊";
				$link = "mail.php?action=login";
			}
			else {
				$psw = password_hash($psw, PASSWORD_DEFAULT);	//加密密碼
				$regtime = time();	//取得申請註冊時間
				$token = password_hash($email, PASSWORD_BCRYPT);	//產生token
				$token_exptime = $regtime + 24*60*60;	//設定token過期時間
				$prepareSQL = "INSERT INTO member(psw, email, token_exptime, status, regtime) VALUES (:psw, :email, :token_exptime, :status, :regtime)";
				$executeSQL = array(':psw' => $psw, ':email' => $email, ':token_exptime' => $token_exptime, ':status' => 0, ':regtime' => $regtime);
				$rowCount = $model->rowCountSQL($prepareSQL, $executeSQL);	//新增資料

				if($rowCount == 1) {	//若新增成功，則進行寄信
					$fromname = "系統註冊信件";
					$subject = "註冊信件";
					$body = "請點擊<a href='http://127.0.0.1/member/php_mvc/mail.php?action=registerWake&email=". $email . "&token=" . $token . "&token_exptime=" . $token_exptime ."' target='_blank'>連結</a>來啟用您的帳號";
					$sendMailStatus = $model->sendMail($fromname, $email, $subject, $body);	//呼叫寄信
					if($sendMailStatus == 1) {	//寄信成功
						$msg = "帳號註冊成功! 請於" . date("Y-m-d H:i:s", $token_exptime) . "前，至信箱啟用帳號!";
						$link = "mail.php?action=login";
					}
					else {
						$msg = "註冊失敗!";
						$link = "mail.php?action=login";
					}
				}
				else {
					$msg = "Somthing error!...";
					$link = "mail.php?action=login";
				}
			}
			require("view/result.php");
			break;

		case 'registerWake':
			$email = stripslashes(trim($_GET['email']));
			$token = stripslashes(trim($_GET['token']));
			$token_exptime = stripslashes(trim($_GET['token_exptime']));

			//驗證信箱
			$prepareSQL = "SELECT * FROM member WHERE email = :email";
			$executeSQL = array(':email' => $email);
			$rowCount = $model->rowCountSQL($prepareSQL, $executeSQL);

			if($rowCount == 1) {
				$registerVerify = password_verify($email, $token);	//驗證token是否相符
				if($registerVerify == 1 && $token_exptime > time()) {	//若token相符 且token沒有過期
					$row = $model->rowDataSQL($prepareSQL, $executeSQL);	//取資料
					$prepareSQL = "UPDATE member SET status = :status WHERE no = :uid";
					$executeSQL = array(':status' => 1, ':uid' => $row['no']);
					$rowCount = $model->rowCountSQL($prepareSQL, $executeSQL);	//更新激活狀態
					if($rowCount == 1) {
						$msg = "帳號驗證成功!";
						$link = "mail.php?action=login";
					}
					else {
						$msg = "Somthing Error!...";
						$link = "mail.php?action=login";
					}
				}
				else {
					$msg = "驗證碼已過期或驗證錯誤，請登入您的帳號重新驗證!";
					$link = "mail.php?action=login";
				}
			}
			else {
				$msg = "該帳號不存在";
				$link = "mail.php?action=login";
			}
			require("view/result.php");
			break;

		case 'forgetPsw':
			require("view/forget_psw.php");
			break;

		case 'forgetPswAction':
			$email = stripslashes(trim($_POST['email']));

			//驗證信箱
			$prepareSQL = "SELECT * FROM member WHERE email = :email";
			$executeSQL = array(':email' => $email);
			$rowCount = $model->rowCountSQL($prepareSQL, $executeSQL);

			if($rowCount == 1) {
				$getpasstime = time();	//取得申請更改密碼時間
				$row = $model->rowDataSQL($prepareSQL, $executeSQL);	//取資料
				$prepareSQL = "UPDATE member SET getpasstime = :getpasstime WHERE no = :uid";
				$executeSQL = array(':getpasstime' => $getpasstime, ':uid' => $row['no']);
				$rowCount = $model->rowCountSQL($prepareSQL, $executeSQL);	//將取得密碼時間存入資料庫

				if($rowCount == 1){
					$token = password_hash($email, PASSWORD_BCRYPT);	//產生token
					$psw = $model->change_psw();	//呼叫function 產生亂數密碼
					$url = "http://127.0.0.1/member/php_mvc/mail.php?action=resetPsw&email=".$email."&token=".$token."&psw=".$psw."&getpasstime=".$getpasstime;
					$time = date("Y-m-d H:i", $getpasstime);	//欲顯示的申請時間
					$failedTime = date("Y-m-d H:i:s", $getpasstime + 24*60*60);	//欲顯示的過期時間
					$fromname = "忘記密碼信件";
					$subject = "忘記密碼";
					$body = "提出修改密碼時間：".$time."<br />點擊<a href=".$url." traget='_blank'>連結</a>更改密碼<br />新密碼為：" . $psw . "<br />請盡早進行密碼更改";
					$sendMailStatus = $model->sendMail($fromname, $email, $subject, $body);	//呼叫寄信
					if($sendMailStatus == 1) {
						$msg = "修改密碼請求成功! 請於" . $failedTime . "前，至信箱更改密碼!";
						$link = "mail.php?action=login";
					}
					else {
						$msg = "Somthing Error!...";
						$link = "mail.php?action=login";
					}
				}
				else {
					$msg = "Somthing Error!...";
					$link = "mail.php?action=login";
				}
			}
			else {
				$msg = "該帳號不存在!";
				$link = "mail.php?action=login";
			}
			require("view/result.php");
			break;

		case 'resetPsw':
			$email = stripslashes(trim($_GET['email']));
			$token = stripslashes(trim($_GET['token']));
			$psw = stripslashes(trim($_GET['psw']));
			$psw = password_hash($psw, PASSWORD_DEFAULT);
			$getpasstime = $_GET['getpasstime'];
			
			//驗證信箱
			$prepareSQL = "SELECT * FROM member WHERE email = :email";
			$executeSQL = array(':email' => $email);
			$rowCount = $model->rowCountSQL($prepareSQL, $executeSQL);

			if($rowCount == 1) {
				$pswVerify = password_verify($email, $token);	//驗證token
				if($pswVerify == 1 && time() - $getpasstime < 24*60*60) { //判斷token是否相符 且 token未過期
					$row = $model->rowDataSQL($prepareSQL, $executeSQL);	//取資料
					$prepareSQL = "UPDATE member SET psw = :psw WHERE no = :uid";
					$executeSQL = array(':psw' => $psw, ':uid' => $row['no']);
					$rowCount = $model->rowCountSQL($prepareSQL, $executeSQL);	//判斷是否修改成功
					if($rowCount == 1) {
						$msg = "密碼已變更，請盡早去更換密碼!";
						$link = "mail.php?action=login";
					}
					else {
						$msg = "驗證失敗";
						$link = "mail.php?action=login";
					}
				}
				else {
					$msg = "驗證失敗";
					$link = "mail.php?action=login";
				}
			}
			else {
				$msg = "該帳號不存在";
				$link = "mail.php?action=login";
			}
			require("view/result.php");
			break;

		default:
			require("view/error.php");
			break;
	}
}
else{
	require("view/error.php");
}