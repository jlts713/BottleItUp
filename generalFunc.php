﻿<?php
	
	if (isset($_SESSION['userid'])){
		date_default_timezone_set('Asia/Taipei');
		$dateTime = explode(' ', $_SESSION['lastlogin']);
		$date = str_replace("-", "", $dateTime[0]);
		if (date('Ymd', time()) != $date){
			$score = $_SESSION['score'] += 20;
			$throwNum = ( $_SESSION['thrownum'] = 0 );
			$pickNum = ( $_SESSION['picknum'] = 0 );
			$lastLogin = ( $_SESSION['lastlogin'] = date('Y-m-d H:i:s') );
			$uid = $_SESSION['userid'];
			$sql = "UPDATE user SET score='$score', thrownum='$throwNum', picknum='$pickNum' , lastlogin='$lastLogin' WHERE userid='$uid'";
			mysql_query($sql);
		}
	}
		echo '<meta http-equiv=REFRESH CONTENT=0;url=index.php>';
	}
	
	
	// 防止惡意輸入
	function preventHike(&$str){
		$str = trim($str);
		$str = stripslashes($str);
		$str = mysql_real_escape_string($str);
		$str = htmlspecialchars($str);
	}
	
	// 驗證管理員身分
	function checkAdmin(){
		if ($_SESSION['admin'] == 0){
			echo '您並非管理員<br>沒有權限進入本頁';
			echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
			exit;
		}
	}
?>