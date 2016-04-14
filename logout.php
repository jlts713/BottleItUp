<?php
	session_start();
	session_destroy();
	//header("Location:index.php");
	echo '<meta http-equiv=REFRESH CONTENT=0;url=index.php>';
?>