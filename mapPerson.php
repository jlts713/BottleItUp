<?php
	session_start();
	include("mysqlInc.php");
	include ("generalFunc.php");
	include ("personalMap.php");
?>

<script>
	var jsonString = <?php echo json_encode($jsonArray)?>;
	var jsonConStr = <?php echo json_encode($jsonCArray)?>; 
</script>

<html> 
  <head>
    <title>Bottle It Up</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel=stylesheet type="text/css" href="./css/mapPerson.css">
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
    
	<script type="text/javascript" src="./js/bottleMap.js"></script>
	<script type="text/javascript" src="./js/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBKWHW1NqHq16XtT0fvTcaNpdvQ-P0pYrg"></script>
	<script type="text/javascript" src="./js/markerclusterer.js"></script>
	
  </head>
  
  <body onload="initialize();">
	<!--insert Map API-->
	<div id="mapCanvas"></div>
	
	<div id="submitBox">
		<form id="getId" action="getBottleId.php" method="post">
			<input type="hidden" name="bid" value=""></input>
			<p>You want to check this bottle?</p><br>
			<input class="btn" type="submit" value="Yes"></input>
			<input class="btn" type="button" value="No" onclick="hideBox()"></input>
		</form>
	</div>
	
	<!--div id='actionBar'-->
	<div id='tt'>
		<ul class="actionItem">
			<li id="item" class="i1">
				<img src="https://m101.nthu.edu.tw/~s101080011/action.png" id='action'>
	<!--insert link to action toThrow>>throwBottle toFollow>>personFollowBottle leave>>logout-->				
				<ul><div id='actionBar'><table>
					<tr>
					<td><a href="mapMain.php"><img src="https://m101.nthu.edu.tw/~s101080011/toMap.png" style="height:100px;position: absolute;bottom: 0%;left: 10%;" id='detail' class='toMap'></a></td>
					<td><a href="throwBottle.php"><img src="https://m101.nthu.edu.tw/~s101080011/toThrow.png" style="height:100px;position: absolute;bottom: 0%;left: 32%;" id='detail' class='toThrow'></a></td>
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
