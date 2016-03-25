<?php
class model{

	function __construct(PDO $dbh) {
		$this->dbh = $dbh;
	}

	function rowDataSQL($prepareSQL, $executeSQL) {	//給予Controller 取資料
		$dbh = $this->dbh;
		$sql = $dbh->prepare($prepareSQL);
		$sql->execute($executeSQL);
		return $sql->fetch();
		// $row = $sql->fetch();
		// $rows = $sql->fetchAll();
		// $rowCount = $sql->rowCount();
		// return array($row, $rows, $rowCount);
	}

	function getDataSQL($prepareSQL, $executeSQL) { //顯示資料
		$dbh = $this->dbh;
		$sql = $dbh->prepare($prepareSQL);
		$sql->execute($executeSQL);
		return $sql->fetchAll();
	}

	function rowCountSQL($prepareSQL, $executeSQL) { //執行資料並回傳結果的Boolean
		$dbh = $this->dbh;	
		$sql = $dbh->prepare($prepareSQL);
		$sql->execute($executeSQL);
		return $sql->rowCount();
		// return $dbh->lastInsertId(); //顯示成功筆數
	}

	function change_psw() { //產生隨機密碼
		$randomPsw = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$randomPsw = substr(str_shuffle($randomPsw), 0, 8);
		return $randomPsw;
	}

	function sendMail($fromname, $email, $subject, $body) { //寄信
		require('./mail_smtp/PHPMailerAutoload.php');
		mb_internal_encoding('utf-8');   					//設置信件內文編碼格式
		$mail = new PHPMailer;
		$mail->isSMTP();                                    // 設定寄信走SMTP
		$mail->SMTPAuth = true;                             // 啟用SMTP即時驗證
		//$mail->SMTPDebug = 3;								// 偵錯SMTP用，ex:2,3,4
		$mail->Host = 'smtp.gmail.com:465';					// 設定SMTP主機位置(我們這邊借用Google的SMTP伺服器)
		$mail->Username = 'nicky.smtp.nutc@gmail.com';		//設定寄信的帳號
		$mail->Password = 'a1111111111';					// 密碼
		$mail->SMTPSecure = 'ssl';                         	// 設定SMTP的傳輸安全機制是tls還是ssl
		$mail->Port = 465;                                  // 設定TCP的Port
		$mail->FromName = $fromname;						//信件是誰寄送的
		$mail->addAddress($email, 'Web User');				// 收件信箱、使用者名字
		//$mail->addCC('');									//副本
		//$mail->addBCC('');								//密件副本
		//$mail->addAttachment('/var/tmp/file.tar.gz');		// 附帶附件
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');// 附帶圖片檔
		$mail->isHTML(true);								// 設定信件是HTML格式(False的話就全都是文字)
		$mail->Subject = $subject;
		$mail->Body = $body;
		return $mail->send();
	}
}