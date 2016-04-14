<?php
	session_start();
	include("mysqlInc.php");
	include("generalFunc.php");
	//設有$_SESSION['userID'],$_SESSION['userNickname']
	//$_SESSION['bottleid']
?>

<?php

	//search bottle type by bottle ID
	$bid = $_SESSION['bottleid'];
	$sql="SELECT type FROM bottle WHERE bottleid='$bid'";
	$result=mysql_query($sql);
	$row = mysql_fetch_array($result);
	$type=$row['type'];
	
	//assign background as bottle type
	if($type==1){ 
		$str= '<body style="margin:0; padding:0; 
			background: #000 url(\'https://m101.nthu.edu.tw/~s101080011/pickD.jpg\') center center fixed no-repeat;
			background-size: cover;">';
	}else if($type==2){
		$str= '<body style="margin:0; padding:0; 
			background: #000 url(\'https://m101.nthu.edu.tw/~s101080011/pickS.jpg\') center center fixed no-repeat;
			background-size: cover;">';
	}else{
		$str= '<body style="margin:0; padding:0; 
			background: #000 url(\'https://m101.nthu.edu.tw/~s101080011/pickG.jpg\') center center fixed no-repeat;
			background-size: cover;">';
	}
	echo $str;
?>

<?php
	function showMsg($replyRow){
		$rUid = $replyRow['userid'];
		
		$replyerSQL = "SELECT nickname FROM user WHERE userid = '$rUid'";
		$replyerResult = mysql_query($replyerSQL);
		$replyerRow = mysql_fetch_array($replyerResult);
		$rcontent = $replyRow['content'];
		$rcontent = str_replace('
', '<br>', $rcontent);
		echo "<div class='content'>";
		echo "<p class='msg'>".$rcontent."</p><br>";
		echo "<span class='penName'>BY ".$replyerRow['nickname']."  </span><br>";
		echo "<span class='replyTime'>".$replyRow['time']."</span>";
		echo "</div>";
	}
?>

<html>
<head>
	<title>Bottle It Up</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel=stylesheet type="text/css" href="./css/contentBottle.css">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
	
</head>

<body>
	
	<input type="button" id="replyBtn" class="btn" value="REPLY" onClick="location.href='ReplyBottle.php'"></input>
	<div id="writer">
	<!--Topic content-->
		<?php  
			$bid = $_SESSION['bottleid'];
			$bottleSQL = "SELECT * FROM bottle WHERE bottleid = '$bid'";
			$bottleResult = mysql_query($bottleSQL);
			$bottleRow = mysql_fetch_array($bottleResult); 
			$bcontent = $bottleRow['content'];
			$bcontent = str_replace('
', '<br>', $bcontent);
			 
			$uid = $bottleRow['userid'];
			$userSQL = "SELECT * FROM user WHERE userid = '$uid'";
			$userResult = mysql_query($userSQL); 
			$userRow = mysql_fetch_array($userResult);
			
			echo "<div class='content' style='background-color:rgba(255,255,255,0.8);'>";
			echo "<p class='msg'>".$bcontent."</p><br>";  
			echo "<span class='penName'>BY ".$userRow['nickname']."  </span><br>";
			echo "<span class='replyTime'>".$bottleRow['time']."</span>";
			
			echo "</div>";
		?>
		
		<!--Reply content-->
		<?php
			$bid = $_SESSION['bottleid'];
			$replySQL = "SELECT * from reply WHERE bottleid='$bid'";
			$replyResult = mysql_query($replySQL);
			while($replyRow = mysql_fetch_array($replyResult)){
				showMsg($replyRow);
			}
		?>
		
	</div>
	
	<!--div id='actionBar'-->
	<div id='tt'>
		<ul class="actionItem">
			<li id="item" class="i1">
				<img src="https://m101.nthu.edu.tw/~s101080011/action.png" id='action'>
	<!--insert link to action toMap>>mainPage toFollow>>personFollowBottle toPerson>>personalInformation leave>>logout-->				
				<ul><div id='actionBar'><table>
					<tr>
					<td><a href="./mapMain.php"><img src="https://m101.nthu.edu.tw/~s101080011/toMap.png" style="height:100px;position: absolute;bottom: 0%;left: 10%;" id='detail' class='toMap'></a></td>
					<td><a href="./mapPerson.php"><img src="https://m101.nthu.edu.tw/~s101080011/toFollow.png" style="height:100px;position: absolute;bottom: 0%;left: 32%;" id='detail' class='toFollow'></a></td>
					<td><a href="member.php"><img src="https://m101.nthu.edu.tw/~s101080011/toPerson.png" style="height:100px;position: absolute;bottom: 0%;left: 54%;" id='detail' class='toPerson'></a></td>
					<td><a href="logout.php"><img src="https://m101.nthu.edu.tw/~s101080011/leave.png" style="height:70px;position: absolute;bottom: 0%;left: 76%;" id='detail' class='leave'></a></td>
					</tr>
				</table></div></ul>
			</li>
		</ul>
	</div>
	<!--/div-->
 
</body>
</html>