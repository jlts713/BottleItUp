<?php
	session_start();
	include("mysqlInc.php");
?>
<?php
	// 登入
	if (isset($_POST['account']) && isset($_POST['password']) && $_POST['account'] && $_POST['password']){
		$acc = $_POST['account'];
		$pwd = $_POST['password'];
		$pwd = md5($pwd);
		
		$sql = "SELECT * FROM user WHERE account = '$acc'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		
		// 帳號不存在
		if ($row == null){
			echo "<script>alert('帳號不存在')</script>";
			echo '<meta http-equiv=REFRESH CONTENT=0;url=index.php>';
			exit;
		}
		// 帳號存在
		else{
			// 密碼錯誤
			if ($pwd != $row['pwd']){
				echo "<script>alert('密碼錯誤')</script>";
				echo '<meta http-equiv=REFRESH CONTENT=0;url=index.php>';
				exit;
			}
			// 密碼正確，可以登入
			else{
				$_SESSION['userid'] = $row['userid'];
				$_SESSION['account'] = $row['account'];
				$_SESSION['pwd'] = $row['pwd'];
				$_SESSION['nickname'] = $row['nickname'];
				$_SESSION['score'] = $row['score'];
				$_SESSION['thrownum'] = $row['thrownum'];
				$_SESSION['picknum'] = $row['picknum'];
				$_SESSION['admin'] = $row['admin'];
				$_SESSION['lastlogin'] = $row['lastlogin'];
				/* 更新登入時間 */				date_default_timezone_set('Asia/Taipei');								$curTime = date('Y-m-d H:i:s', time());
				$sql = "UPDATE user SET lastlogin='$curTime' WHERE account='$acc'";
				mysql_query($sql);
				// 管理員
				if ($_SESSION['admin'] == 1)
					echo '<meta http-equiv=REFRESH CONTENT=0;url=manage.php>';
				// 一般用戶
				else
					echo '<meta http-equiv=REFRESH CONTENT=0;url=mapMain.php>';
			}
		}
	}
?>