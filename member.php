<?php
session_start();
include("mysqlInc.php");
include("generalFunc.php");

$uid = $_SESSION['userid'];
$acc = $_SESSION['account'];
$pwd = $_SESSION['pwd'];
$nn = $_SESSION['nickname'];
$score = $_SESSION['score'];

// 修改用戶名
if(isset($_POST['nickname']) && $_POST['nickname']){
	$nn_new = $_POST['nickname'];
	preventHike($nn_new);
	// 進行修改
	$sql = "UPDATE user SET nickname='$nn_new' WHERE userid='$uid'";
	mysql_query($sql);
	$nn = ($_SESSION['nickname'] = $nn_new);
}

// 修改密碼
if(isset($_POST['password']) && $_POST['password']){
	$pwd_ori = $_POST['pwdOri'];
	$pwd_new = $_POST['password'];
	$pwd_check = $_POST['pwdCheck'];
	if (md5($pwd_ori) != $pwd)
		echo "<script>alert('原始密碼錯誤')</script>";
	else if ($pwd_new != $pwd_check)
		echo "<script>alert('密碼前後不符')</script>";
	else{
		// 進行修改
		$pwd_new = md5($pwd_new);
		$sql = "UPDATE user SET pwd='$pwd_new' WHERE userid='$uid'";
		mysql_query($sql);
		$pwd = ($_SESSION['pwd'] = $pwd_new);
		echo "<script>alert('密碼已變更')</script>";
	}
}
?>
<html>
<head>
    <meta name="loginPage"
    content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
	<link rel=stylesheet type="text/css" href="css/member.css">
	
	<title>Bottle It Up</title>
	<style>
		
		
		
	</style>
</head>
<body>
	
	<center>
	<form id="userInfo" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<br>
	<h1><?php echo $acc ?></h1>
	<table>
	<tr>
		<td width="100px">Nickname</td>
		<td width="200px">
		<?php
			echo $nn;
			if (isset($_GET['section']) && $_GET['section']=='nickname')
				echo '<br><input type="text" name="nickname">';
			else
				echo '<br><a href="'.$_SERVER['PHP_SELF'].'?section=nickname">編輯</a>';
		?>
		</td>
	</tr>
	
	<tr>
		<td>Password</td>
		<td>
		<?php
			if (isset($_GET['section']) && $_GET['section']=='pwd'){
				echo '原始密碼 <input type="password" name="pwdOri" size="10"><br>';
				echo '變更密碼 <input type="password" name="password" size="10"><br>';
				echo '確認密碼 <input type="password" name="pwdCheck" size="10">';
			}
			else
				echo '<br><a href="'.$_SERVER['PHP_SELF'].'?section=pwd">修改密碼</a><br><br>';
		?>
		</td>
	</tr>
	
	<tr><td>Credit</td><td><?php echo $score?></td></tr>
	</table>
	<p>
		<input type="submit" name="submit" class="btn" value="confirm">
		<input type="button" class="btn" value="cancel" onclick="document.location.href='member.php'">
	</p>
	<br>
	</form>
	</center>
	
	<!--actionBar-->
	<div id='tt'>
		<ul class="actionItem">
			<li id="item" class="i1">
				<img src="https://m101.nthu.edu.tw/~s101080011/action.png" id='action'>
				<ul><div id='actionBar'><table>
					<tr>
					<td>
						<a href="mapMain.php">
						<img src="https://m101.nthu.edu.tw/~s101080011/toMap.png" style="height:100px;position: absolute;bottom: 0%;left: 15%;" id='detail' class='toMap'></td>
						</a>
					<td>
						<a href="mapPerson.php">
						<img src="https://m101.nthu.edu.tw/~s101080011/toFollow.png" style="height:100px;position: absolute;bottom: 0%;left: 40%;" id='detail' class='toFollow'></td>
					<td>
						<a href="logout.php">
						<img src="https://m101.nthu.edu.tw/~s101080011/leave.png" style="height:70px;position: absolute;bottom: 0%;left: 65%;" id='detail' class='leave'>
						</a>
					</td>
					</tr>
				</table></div></ul>
			</li>
		</ul>
	</div>

</body>
</html>
