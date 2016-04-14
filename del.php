<?php

	session_start();

	include("mysqlInc.php");

	include("generalFunc.php");

?>

<?php

	// 驗證是否為管理員

	checkAdmin();	

	// 刪除瓶子

	$sql = 'DELETE FROM bottle WHERE bottleid = '.$_GET['bid'];

	$result = mysql_query($sql);

	header("Location:manage.php");

?>