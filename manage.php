﻿<?php
	session_start();
	include("mysqlInc.php");
	include("generalFunc.php");
	
	// 驗證管理員身分
	checkAdmin()
?>

<!--管理員權限變更-->
<script>
	function set(uid, adminType){
		sql = "UPDATE user SET admin='" + adminType + "' WHERE userid='" + uid + "'";
		document.all.query.value = sql;
	}
</script>
<?php
	// 管理員權限變更
	if (isset($_POST['query']))
		mysql_query($_POST['query']);
?>

<html>
<head>
	<title>管理員介面</title>
	<meta charset="utf-8">
	<meta name="loginPage"
		content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
</head>

<body style="background-image:url(img/manage_bg.jpg); background-attachment:fixed"><center>

	<form name="adminSetup" method="post">
		<table border="1" style="text-align:center; background:rgba(230,200,170,0.8)">
			<tr>
				<th>帳號</th>
				<th>管理員設定</th>
			</tr>
			<?php
				while($row = mysql_fetch_array($result)){
					echo "<tr><td>".$row['account']."</td>";
					if ($row['admin'] == 0)
						echo '<td><input type="submit" value="設為管理員" onclick="set('.$row['userid'].', 1)"></td></tr>';
					else
						echo '<td><input type="submit" value="移除管理員" onclick="set('.$row['userid'].', 0)"></td></tr>';
				}
			?>
		</table>
		<input type="hidden" name="query">
	</form>

</body>
</html>