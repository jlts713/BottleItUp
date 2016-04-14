<?php
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
	}	function viewSection(formName){		if (formName == "adminSetup"){			document.adminSetup.style.visibility = "visible";			document.bottles.style.visibility = "hidden";		}		else if (formName == "bottles"){			document.bottles.style.visibility = "visible";			document.adminSetup.style.visibility = "hidden";		}	}
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
	<!-- view users -->
	<form name="adminSetup" method="post">	<h1>管理員設定</h1>
		<table border="1" style="text-align:center; background:rgba(230,200,170,0.8)">
			<tr>
				<th>帳號</th>
				<th>管理員設定</th>
			</tr>
			<?php				$sql = "SELECT userid, account, admin FROM user WHERE userid!='".$_SESSION['userid']."'";				$result = mysql_query($sql);
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
	</form>	<!-- view bottles -->	<form name="bottles" style="visibility:hidden; position:absolute; top:20px; left:50%; margin-left:-375px">		<h1>檢視瓶子們</h1>		<table border="1" style="text-align:center; background:rgba(230,200,170,0.8)">			<tr>				<th>丟瓶者</th>				<th>丟瓶類型</th>				<th>內容</th>				<th>丟瓶時間</th>				<th>刪除</th>			</tr>			<?php				$sql = "SELECT user.nickname, subtable.* FROM (SELECT * FROM bottle) AS subtable, user WHERE user.userid = subtable.userid";				$result = mysql_query($sql);				while($row = mysql_fetch_array($result)){					echo "<tr><td width='70px'>".$row['nickname']."</td>";										if ($row['type']==1) echo "<td width='100px'>心情分享</td>";											else if ($row['type']==2) echo "<td width='100px'>故事接龍</td>";											else if ($row['type']==3) echo "<td width='100px'>廢文</td>";										echo "<td width='300px' style='text-align:left; word-break:break-all'>".$row['content']."</td>";										echo "<td width='200px'>".$row['time']."</td>";										echo "<td width='80px'><a href='del.php?bid=".$row['bottleid']."'>移除瓶子</a></td></tr>";				}			?>		</table>	</form>	<!-- action bar -->	<table border="1" style="text-align:center; position:fixed; left:5px; top:50px; background:rgba(255,255,200,0.7)">		<tr>			<th>管理員介面</th>						<th>使用者介面</th>					</tr>				<tr>			<td onclick="viewSection('adminSetup')" style="cursor:pointer; color:blue">管理員設定</td>			<td><a href="throwBottle.php"><img src="https://m101.nthu.edu.tw/~s101080011/toThrow.png" width="50px"><br>丟新瓶子</a></td>		</tr>					<tr>			<td onclick="viewSection('bottles')" style="cursor:pointer; color:blue">檢視瓶子們</td>			<td><a href="mapMain.php"><img src="https://m101.nthu.edu.tw/~s101080011/toMap.png" width="50px"><br>main map</a></td>		</tr>				<tr>			<td></td>			<td><a href="mapPerson.php"><img src="https://m101.nthu.edu.tw/~s101080011/toFollow.png" width="50px"><br>personal map</a></td>		</tr>		<tr>			<td></td>			<td><a href="member.php"><img src="https://m101.nthu.edu.tw/~s101080011/toPerson.png" width="50px"><br>member</a></td>		</tr>		<tr>			<td></td>			<td><a href="logout.php"><img src="https://m101.nthu.edu.tw/~s101080011/leave.png" width="50px"><br>logout</a></td>		</tr>	</table>

</body>
</html>