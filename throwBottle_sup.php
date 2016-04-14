<?php
include("mysqlInc.php");
include("generalFunc.php");
//設有$_SESSION['userID'],$_SESSION['userNickname']
?>
<?php
		//撈 MAX(BottleID)
		$Id = "SELECT MAX(bottleid) AS 'max' FROM bottle";
		$result = mysql_fetch_array(mysql_query($Id));
		$max = $result['max']+1;
		
		//儲存PO文
		if(isset($_POST['content']) &&isset($_POST['type']) && (($_POST['go']=='1')||(($_POST['lng']!='')&& ($_POST['lat']!='')))&& isset($_POST['follow']) &&$_POST['content']){
			$userID = $_SESSION['userid'];
			$content = $_POST['content'];
		//BOZZ防hike
			preventHike($content);
			$content = nl2br($content);
			//準備其他變數
			$type = $_POST['type'];
			$curTime = corTime();
		//存入帖子
			$sql = "INSERT INTO bottle (bottleid, userid, type, content, time) VALUES ('$max','$userID','$type','$content','$curTime')";
			mysql_query($sql);
		//存入地點
			if($_POST['go']=='0'){
				if(($_POST['lng']!='')&& ($_POST['lat']!='')){
					$lng = $_POST['lng'];
					$lat = $_POST['lat'];
					$sql = "INSERT INTO place (bottleid, longitude, latitude) VALUES ('$max','$lng','$lat')";
					mysql_query($sql);
				}else{
					echo "<script>alert('Ooops! You forgot to Geo!');</script>";
					
				}
			}else{
				$lng = rand(-180,180);
				$lat = rand(-90,90);
				$sql = "INSERT INTO place (bottleid, longitude, latitude) VALUES ('$max','$lng','$lat')";
				mysql_query($sql);
			}
		//UPDATE積分
			$Id = "SELECT score,thrownum FROM user WHERE user.userid='$userID'";
			$result = mysql_fetch_array(mysql_query($Id));
			$sc = $result['score'] +10;//加積分
			$_SESSION['score'] = $sc;
			$tn = $result['thrownum'] +1;//加發文數
			$_SESSION['thrownum'] = $tn;
			$sql = "UPDATE user SET score='$sc',thrownum='$tn' WHERE user.userid='$userID'";
			mysql_query($sql);
		//存入follow
			if($_POST['follow']==1){
				$sql = "INSERT INTO follow (userid, bottleid) VALUES ('$userID','$max')";
				mysql_query($sql);
			}
			echo '<meta http-equiv=REFRESH CONTENT=0;url=./mapMain.php>';
		}else if(isset($_POST['submit'])){
			echo "<script>alert('Ooops! You miss something or forgot to Geo!');</script>";
		}
?>
<html><head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
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
	<style>
		#map_canvas{
			 position:absolute; top:0px; right:0px;
		}
	</style>
</head><body></body></html>