
<?php
	$jsonArray= array();
	$jsonCArray = array();
	//fetch bottle data from mysql
	$bottleSQL = "SELECT * FROM bottle";
	
	$bottleResult = mysql_query($bottleSQL) or die("Error: ". mysql_error(). " with query ");

	
	//$bottleRow = mysql_fetch_array($bottleResult);
	//echo '<script>alert("num of rows = '.mysql_num_rows($bottleResult).'"</script>';
	
	while($bottleRow = mysql_fetch_array($bottleResult)){
		$bid = $bottleRow['bottleid'];
		$btype = $bottleRow['type'];
		//echo '<script>alert('.$bid.');</script>';
		$placeSQL = "SELECT * FROM place WHERE bottleid = '$bid' ORDER BY time DESC LIMIT 1";
		$placeResult = mysql_query($placeSQL) or die("Error: ".mysql_error(). " with query ");
		$placeRow = mysql_fetch_array($placeResult);
		
		$lat = $placeRow['latitude'];
		$lng = $placeRow['longitude'];
		
		$uid = $_SESSION['userid'];
		$followSQL = "SELECT * FROM follow WHERE bottleid= '$bid' AND userid= '$uid'";
		$followResult = mysql_query($followSQL);
		//echo '<script>alert("'.$_SESSION['userid'].'");</script>';
		if(mysql_num_rows($followResult) == 0){
			//echo '<script>alert("There!");</script>';
			$jsonData['follow'] = '0';
			$jsonContent['content'] = '0';
			$jsonContent['nickname'] = '0';
			$jsonContent['time'] = '0';
			array_push($jsonCArray, $jsonContent);
		}else{
			//echo '<script>alert("here!");</script>';
			$jsonData['follow'] = '1';
			$contentSQL = "SELECT * FROM bottle WHERE bottleid = '$bid'";
			$contentResult = mysql_query($contentSQL);
			$contentRow = mysql_fetch_array($contentResult);  
			$bcontent = $contentRow['content'];
			$bcontent = str_replace('
', '<br>', $bcontent);
			
			$writerid = $contentRow['userid'];
			$writerSQL = "SELECT * FROM user WHERE userid = '$uid'";
			$writerResult = mysql_query($writerSQL);  
			$writerRow = mysql_fetch_array($writerResult);
			 
			$jsonContent['content'] = $bcontent; 
			$jsonContent['nickname'] = $writerRow['nickname'];
			$jsonContent['time'] = $contentRow['time'];
			array_push($jsonCArray, $jsonContent);
		}
		
		$jsonData['bid'] = $bid;
		$jsonData['btype'] = $btype;
		$jsonData['lat'] = $lat;
		$jsonData['lng'] = $lng;
		array_push($jsonArray, $jsonData); 
    }
	
	//echo '<script>var jsonString = '.json_encode($jsonArray).';</script>';
?>