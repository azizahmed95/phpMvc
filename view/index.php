<?php

	include("../config/config.php");
	include("../config/dbutils.php");

	$conn = DbConnect($host,$user,$pass,$dbname);


	printArr($conn);

?>