<?php
	session_start();
	
	if(isset($_POST['bid'])){
		$_SESSION['bottleid'] = $_POST['bid'];
		echo '<meta http-equiv=REFRESH CONTENT=0;url="contentBottle.php">';
		//$b = $_POST['bid'];
		//echo $_POST['bid'];
		//echo '<script>alert('.$_POST['bid'].');</script>';
	}
	
?>