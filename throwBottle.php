<?php  //change php position
	session_start();
	include("mysqlInc.php");
	include("throwBottle_sup.php");
?>

<html>
	<head>
		<title>Bottle It Up</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel=stylesheet type="text/css" href="./css/throwBottle.css">
		<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>

	</head>
	<body onload="initialize()"><center>
		<div id="map_canvas" style="width:20%; height:100%" ></div>
		
		<div id='writer'>
			<table id='content'>
			<font class="title">THROW A BOTTLE</font>
			<br>
			<form action ="" Method ="Post">
				<font class="topic">What I wanna say：</font><br>
				<textarea rows="10" cols="20" name="content" class="textarea"></textarea><br>
							
				<font class="topic">Bottle Category：</font><br>
				<input type="radio" name="type" value="1" id="a" checked><label for="a">心情分享</label>
				<input type="radio" name="type" value="2" id="b"><label for="b">故事接龍</label>
				<input type="radio" name="type" value="3" id="c"><label for="c">廢文</label><br>
						
				<font class="topic">Bottle Location：</font><br>
				<div class="opt">
					<input type="radio" name="go" value="0" checked>
					<input type="textbox" id="address" value="新竹市光復路二段101號 ">
					<input type="button" value="Geocode" class="btn" id="Geo" onclick="codeAddress()"><br/>
					<font class="word">（經緯度：<input type="textbox" name="lat" id="lat" value=""><input type="textbox" name="lng" id="lng" value="">）</font><br/>
				</div>
				<div class="opt">
					<font class="word"><input type="radio" name="go" value="1" id="d"><label for="d">Let It Go~~~Randomly~~~</label></font>
				</div>
				
				<font class="topic">Do You Wanna Follow This Bottle?</font>
				<input type="radio" name="follow" value="1" id="e" checked><label for="e">Yes, of course!</label>
				<input type="radio" name="follow" value="0" id="f"><label for="f">No, bye Bottle~</label>
				
				<input type="submit" value="Throw" name="submit" class="btn"><br/>
			</form>
			</table>
		</div>
		
		<!--div id='actionBar'-->
		<div id='tt'>
			<ul class="actionItem">
				<li id="item" class="i1">
					<img src="https://m101.nthu.edu.tw/~s101080011/action.png" id='action'>
		<!--insert link to action toMap>>mainPage toFollow>>personFollowBottle toPerson>>personalInformation leave>>logout-->				
					<ul><div id='actionBar'><table>
						<tr>
						<td><a href="mapMain.php"><img src="https://m101.nthu.edu.tw/~s101080011/toMap.png" style="height:100px;position: absolute;bottom: 0%;left: 10%;" id='detail' class='toMap'></a></td>
						<td><a href="mapPerson.php"><img src="https://m101.nthu.edu.tw/~s101080011/toFollow.png" style="height:100px;position: absolute;bottom: 0%;left: 32%;" id='detail' class='toFollow'></a></td>
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
