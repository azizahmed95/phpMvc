<?php
	include("../config/config.php");			
	include("../config/dbutils.php");

	$connAdmin = DbConnect($host,$user,$pass,$dbname);

	if(noError($connAdmin))
	{
		$connAdmin = $connAdmin["errMsg"];
		//printArr($connAdmin);
		/*$returnArr["errCode"] = -1;
		$returnArr["errMsg"] = "Connection succes!";
		printArr($returnArr);*/
	}
	else
	{
		printArr($connAdmin["errMsg"]);die;
		
		/*$returnArr["errCode"] = 6;
		$returnArr["errMsg"] = "Connection Failed!";
		printArr($returnArr);*/
	}

	$countQuery = "SELECT * FROM register";
	$countResult = runQuery($countQuery, $connAdmin);

	$count = mysqli_num_rows($countResult['dbResource']);
	echo $count;

	printArr($countResult);


	while($run = mysqli_fetch_array($countResult['dbResource']))
	{

	echo $run['firstname'] . ' ';
	}



?>