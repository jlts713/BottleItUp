<?php
	session_start();
	include("mysqlInc.php");
	include ("generalFunc.php");
	include ("bottleMap.php");
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
	
	<link rel=stylesheet type="text/css" href="./css/mapMain.css">
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
	<input id="how" class="btn" type="button" value="How to use Bottle It Up?" onclick="showHow()"></input>
	<div id="submitBox">
		<form id="getId" action="getBottleId.php" method="post">
			<input type="hidden" name="bid" value=""></input>
			<p>Are you sure you want to pick up this bottle?</p><br>
			<input class="btn" type="submit" value="Yes"></input>
			<input class="btn" type="button" value="No" onclick="hideBox()"></input>
		</form>
	</div> 
	
	<div id="howBox">
		<form>
			<font id="title1">How to use Bottle It Up?</font><br>
			<input type="hidden" name="bid" value=""></input>
			<font id="words">心情需要抒發的出口， 故事需要分享的管道。
			無法壓抑，but could you Bottle It Up? </font><br>
			
			<font id="title2">｜三種瓶子，三種心情｜</font><br>
			<font id="howto">	
				<img src="./img/wine.png" height="20px"></img>酒瓶｜把酒分享此時此刻的心情<br>		
				<img src="./img/barrel.png" height="20px"></img>橡木桶｜接力釀造一個有趣的故事<br>
				<img src="./img/can.png" height="20px"></img>鋁罐｜垃圾、廢文通通壓扁丟在這裡吧<br>
			</font>
			<font id="title2">｜兩種角色，丟撿自如｜</font><br>
			<font id="howto"> 	【丟瓶人】<br>將話語化為一只瓶中信，任它漂流吧！
								追蹤它可以到個人追蹤地圖上找尋它的最新位置，
								不追蹤就期待與它有緣再會<br>
								【撿瓶人】<br>在茫茫世界中，撿一只與你有緣的瓶中信<br>
								是否回應瓶子主人、是否延續與它的緣分都是你的選擇。回覆有共鳴的瓶子，可以追蹤它，也能為它選擇新地點<br>
			</font>
			<font id="title2">｜寫信、回信方法｜</font><br>
			<font id="howto"> 輸入你想說的話->為瓶子選擇地點(填寫住址、地名或選擇隨機到未知地點)->填地名需點擊Geocode確認位置->選擇是否追蹤此瓶子->丟出瓶子!</font><br>
			<font id="title2">｜主選單選項 About Menu｜</font><br> 
			<font id="howto"> 
				<img src="https://m101.nthu.edu.tw/~s101080011/action.png" height="20px"></img>主選單｜滑鼠移至頁面左下角查看主選單<br>
				<img src="https://m101.nthu.edu.tw/~s101080011/toMap.png" height="20px"></img>瓶子地圖
				<img src="https://m101.nthu.edu.tw/~s101080011/toThrow.png" height="20px"></img>丟瓶子
				<img src="https://m101.nthu.edu.tw/~s101080011/toFollow.png" height="20px"></img>追蹤地圖
				<img src="https://m101.nthu.edu.tw/~s101080011/toPerson.png" height="20px"></img>個人資料
				<img src="https://m101.nthu.edu.tw/~s101080011/leave.png" height="20px"></img>登出
			</font><br><br>
			<input class="btn" type="button" value="OK! 來個瓶中信吧！" onclick="hideHow()"></input>
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
					<td><a href="throwBottle.php"><img src="https://m101.nthu.edu.tw/~s101080011/toThrow.png" style="height:100px;position: absolute;bottom: 0%;left: 10%;" id='detail' class='toThrow'></a></td>
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
