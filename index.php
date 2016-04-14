<?php
	session_start();
	include("mysqlInc.php");
?>

<?php
	/* 已登入之動作 */
	if(isset($_SESSION['userid'])){
		/* 更新登入時間 */		date_default_timezone_set('Asia/Taipei');		$curTime = date('Y-m-d H:i:s', time());
		$sql = "UPDATE user SET lastlogin='$curTime' WHERE userid='".$_SESSION['userid']."'";
		mysql_query($sql);
		/* 重新導向 */
		header("Location:mapMain.php");
		exit;
	}
?>

<html>
<head>
	<title>Bottle It Up</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel=stylesheet type="text/css" href="./css/index.css">
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>	<link href='http://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>
</head>
	
<body>
	<img src="https://m101.nthu.edu.tw/~s101080011/btu.png" style="width:240px;height:240px;" id='logoL'>
	<img src="https://m101.nthu.edu.tw/~s101080011/btu.png" style="width:240px;height:240px;" id='logoR'>
	<img src="https://m101.nthu.edu.tw/~s101080011/btu.png" style="width:240px;height:240px;" id='logoA'>
	<img src="https://m101.nthu.edu.tw/~s101080011/btu.png" style="width:240px;height:240px;" id='logoC'>

	<a name='oldUser' style="position:absolute; top:0"></a>
	<a name='signUP' style="position:absolute; top:100%"></a>
	<a name='about' style="position:absolute; top:200%"></a>
	<a name='contact' style="position:absolute; top:300%"></a>
	
	<!-- Login Account -->
	<p id="login">LOGIN</p>
	<form action="login.php" method="post" style="position:absolute; left:70%; top:25%">
		<table style="color:white">
			<tr><td>Account</td><td><input type="text" name="account" required></td></tr>
			<tr><td>Password</td><td><input type="password" name="password" required></td></tr>
		</table>
		<center><input type="submit" class="btn" value="Login"></center>
	</form>
	<table id="anchorL">
		<tr><td><a class='link' href='#signUp'>Sign Up</a></td></tr>
		<tr><td><a class='link' href='#about'>About</a></td></tr>
		<tr><td><a class='link' href='#contact'>Contact</a></td></tr>
	</table>

	<!-- Create New Account -->
	<p id="new">New Account</p>
	<form action="register.php" method="post" style="position:absolute; left:70%; top:125%">
		<table style="color:white">
		<tr>
			<td align="center" width="95">Account</td>
			<td><input type="text" name="account" required></td>
		</tr>
		<tr>
			<td align="center">Nickname</td>
			<td><input type="text" name="nickname" required></td>
		</tr>
		<tr>
			<td align="center">Password</td>
			<td><input type="password" name="password" required></td>
		</tr>
		<tr>
			<td align="center">Password <br> Confirm</td>
			<td><input type="password" name="pwdCheck" required></td>
		</tr>
		</table>
		<center><input type="submit" class="btn" value="Register"></center>
	</form>
	<table id="anchorR">
		<tr><td><a class='link' href='#oldUser'>Login</a></tr>
		<tr></td><td><a class='link' href='#about'>About</a></td></tr>
		<tr><td><a class='link' href='#contact'>Contact</a></td></tr>
	</table>
	
	<!-- About bottle it up -->
	<p id="discre">About Bottle It Up</p>	<div id="aboutInfo">					<h2 align="center">《Bottle It Up》</h2>		<pre style="font-size:15pt; font-family:'Architects Daughter', cursive">	Follow the bottles upon the journey.<br>	    Traveling will extend your destiny.<br>	        Once the voyage comes to an end.<br>	            Don't worry about worn one,<br>	                start a new phase of next journey.<br>	</div>
	<table id="anchorA">
		<tr><td><a class='link' href='#oldUser'>Login</a></td></tr>
		<tr><td><a class='link' href='#signUp'>Sign Up</a></td></tr>
		<tr><td><a class='link' href='#contact'>Contact</a></td></tr>
	</table>

	<!-- Contact Us -->	<p id="team">Contact Us</p>		<div style="position:absolute; top:305%; left:8%; text-align:center">			<img src="img/Tim.jpg" style="width:200px; border-radius:10px"><br>				<p class="editor">高健庭</p>			</div>		<div style="position:absolute; top:305%; left:43%; text-align:center">			<img src="img/Cindy.jpg" style="width:200px; border-radius:10px"><br>				<p class="editor">陳雨欣</p>			</div>		<div style="position:absolute; top:355%; left:8%; text-align:center">			<img src="img/Joanne.jpg" style="width:200px; border-radius:10px"><br>				<p class="editor">王敬嘉</p>			</div>	<div style="position:absolute; top:355%; left:43%; text-align:center">			<img src="img/yihsuan.jpg" style="width:200px; border-radius:10px"><br>				<p class="editor">吳奕萱</p>		 	</div>	
	<table id="anchorC">
		<tr><td><a class='link' href='#oldUser'>Login</a></td></tr>
		<tr><td><a class='link' href='#signUp'>Sign Up</a></td></tr>
		<tr><td><a class='link' href='#about'>About</a></td></tr>
	</table>
	
</body>
</html>
