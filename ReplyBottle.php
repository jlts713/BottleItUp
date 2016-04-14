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
		//撈 MAX(ReplyID)
		$Id = "SELECT MAX(replyid) AS 'max' FROM reply";
		$result = mysql_fetch_array(mysql_query($Id));
		$max = $result['max']+1;
		
		//存入SQL
		if(isset($_POST['content']) && isset($_POST['go']) && isset($_POST['follow']) && $_POST['content']){
			$userID = $_SESSION['userid'];
			$bottleID = $_SESSION['bottleid'];
			$content = $_POST['content'];
			$curTime = corTime();
		//BOZZ防hike
			preventHike($content);
			$content = nl2br($content);
		//存入帖子
			$sql = "INSERT INTO reply (replyid, bottleid, userid, content, time) VALUES ('$max','$bottleID','$userID','$content','$curTime')";
			mysql_query($sql);
		//存入地點
			if($_POST['go']=='0'){
				if(($_POST['lng']!='')&& ($_POST['lat']!='')){
					$lng = $_POST['lng'];
					$lat = $_POST['lat'];
					$sql = "INSERT INTO place (bottleid, longitude, latitude) VALUES ('$bottleID','$lng','$lat')";
					mysql_query($sql);
				}else{
					echo "<script>alert('Ooops! You forgot to Geo!\n So, the bottle will stay at the original place!');</script>";
				}
			}else{
				$lng = rand(-180,180);
				$lat = rand(-90,90);
				$sql = "INSERT INTO place (bottleid, longitude, latitude) VALUES ('$bottleID','$lng','$lat')";
				mysql_query($sql);
			}
		//UPDATE積分
			$Id = "SELECT score FROM user";
			$result = mysql_fetch_array(mysql_query($Id));
			$sc = $result['score'] +5;//加積分
			$sql = "UPDATE user SET score='$sc' WHERE user.userid='$userID'";
			mysql_query($sql);
		//存入follow
			if($_POST['follow']==1){
				$sql = "INSERT INTO follow (userid, bottleid) VALUES ('$userID','$bottleID')";
				mysql_query($sql);
			}
			echo '<meta http-equiv=REFRESH CONTENT=0;url=./mapMain.php>';
		}else if(isset($_POST['submit'])){
			echo "<script>alert('Ooops! You miss something or forgot to Geo!');</script>";
		}
?>



<html>
<head>
	<title>Bottle It Up</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel=stylesheet type="text/css" href="./css/ReplyBottle.css">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
    
	<!--google map-->
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
	<script>
		var markers = [];
		var map, geocoder, latlng, zoom=7;
		var mapOptions;
		var directionDisplay;
		var directionsService = new google.maps.DirectionsService();
		
		function initialize() {
			geocoder = new google.maps.Geocoder();
			directionsDisplay = new google.maps.DirectionsRenderer();
			latlng = new google.maps.LatLng(24.8, 120.97);
			if (google.loader.ClientLocation) {
				latlng = new google.maps.LatLng(google.loader.ClientLocation.latitude,google.loader.ClientLocation.longitude);
			}
			// Create an array of map styles.
			var styles = [
				{stylers: [{ hue: "#d5b152" },{ saturation: -20 }]},
				{featureType:"road", elementType:"geometry", stylers: [{lightness:50}, {visibility:"simplified"}]},
				{featureType:"all", elementType:"labels", stylers: [{visibility:"off"}]},
				{featureType:"water", elementType:"geometry", stylers: [{ hue:'#beb28a'},{ saturation: -40}]}
			];
			
			// Create a new StyledMapType object, passing it the array of styles,
			// as well as the name to be displayed on the map type control.
			var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});
			
			var mapOptions = {
				center: latlng,
				zoom: zoom,
				mapTypeControlOptions: {
					mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
				},
				minZoom: 3,
				streetViewControl: 0
				//mapTypeId: google.maps.MapTypeId.ROADMAP
			};
		 
			map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
			directionsDisplay.setMap(map);
			
			//Associate the styled map with the MapTypeId and set it to display.
			map.mapTypes.set('map_style', styledMap);
			map.setMapTypeId('map_style');
		} /* end initialize */

		function codeAddress(){
			var address = document.getElementById('address').value;
			geocoder.geocode( 
			{'address': address} ,
				function(results, status){ /* 查詢完成時執行的函式 */
					if(status == google.maps.GeocoderStatus.OK) {
						map.setCenter(results[0].geometry.location);
						map.setZoom(15);
						var marker = new google.maps.Marker({
							map: map,
							position: results[0].geometry.location
						});
						document.getElementById("lat").value = results[0].geometry.location.lat();
						document.getElementById("lng").value = results[0].geometry.location.lng();
					}
					else {
						alert('Geocode was not successful for the following reason: ' + status);
					}
				}
			);
		}
	</script>
	
</head>

<body onload="initialize()"><center>
	<div id="map_canvas" style="width:20%; height:100%"></div>
	<div id='writer'>
		<font class="topic1">REPLY BOTTLE</font><br/><br/>
		<form action ="" Method ="Post">
			<font class="topic2">What I wanna say is that：</font><br/>
			<textarea rows="10" cols="20" name="content" class="textarea">Say Something:)</textarea></br><br/>
			<br/><br/>
			
			<font class="topic3">Next Bottle Location：</font><br/>
			<font class="radio"><input type="radio" name="go" value="0" checked></font>
			<input type="textbox" id="address" value="新竹市光復路二段101號 " class="textbox">
			<input type="button" class="btn" value="Geocode" id="Geo" onclick="codeAddress()"><br/>
			<font class="topic4">（lat, lng：<input type="textbox" name="lat" id="lat" class="boxes" value=""><input type="textbox" name="lng" id="lng" class="boxes" value="">）</font>
			<font class="radio2"><input type="radio" name="go" value="1" id="d"><label for="d">Let It Go~~~Randomly~~~</label></font>
			<br/><br/>
			
			<font class="topic6">Do You Wanna Follow This Bottle?</font>
			<font class="topic7"><input type="radio" name="follow" value="1" id="e" checked><label for="e">Yes, of course!</label>
			<input type="radio" name="follow" value="0" id="f"><label for="f">No, bye Bottle~</label></font>
			<br/><br/>
			
			<input id="throw" type="submit" class="btn" value="Throw"><br/>
		</form>
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