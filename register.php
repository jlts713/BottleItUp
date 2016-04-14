<?php
	session_start();
	include("mysqlInc.php");
	include("generalFunc.php");
?>

<?php
	if(isset($_POST['nickname']) && isset($_POST['account']) && isset($_POST['password']) && $_POST['nickname'] && $_POST['account'] && $_POST['password']){
		$nn = $_POST['nickname'];
		$acc = $_POST['account'];
		$pwd = $_POST['password'];
		$pwd_check = $_POST['pwdCheck'];
		/* 防止惡意輸入 */
		preventHike($nn);
		preventHike($acc);
		/* 確認密碼 */
		if ($pwd != $pwd_check){
			echo "<script>alert('密碼前後不一致')</script>";
			echo '<meta http-equiv=REFRESH CONTENT=0;url=index.php#signup>';
			exit;
		}
		$pwd = md5($pwd);
		/* 檢查帳號是否重複 */
		$sql = "SELECT account, nickname FROM user";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result)){
			if ($acc==$row['account']){
				echo "<script>alert('此帳號已有人註冊')</script>";
				echo '<meta http-equiv=REFRESH CONTENT=0;url=index.php#signup>';
				exit;
			}
		}
		/* 沒問題可註冊 */
		$sql = "INSERT INTO user (account, pwd, nickname) VALUES ('$acc', '$pwd', '$nn')";
		mysql_query($sql);
		
		$sql = "SELECT * FROM user WHERE account = '$acc'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$_SESSION['userid'] = $row['userid'];
		$_SESSION['account'] = $row['account'];
		$_SESSION['pwd'] = $row['pwd'];
		$_SESSION['nickname'] = $row['nickname'];
		$_SESSION['score'] = $row['score'];
		$_SESSION['thrownum'] = $row['thrownum'];
		$_SESSION['picknum'] = $row['picknum'];
		$_SESSION['admin'] = $row['admin'];
		$_SESSION['lastlogin'] = $row['lastlogin'];
		
		echo '<script>document.getElementsByTagName("form")[0].innerHTML="<br>註冊成功<br>1秒後跳轉<br><br>"</script>';
		// 註冊好跳轉到主地圖
		echo '<meta http-equiv=REFRESH CONTENT=1;url=mapMain.php>';
	}
?>