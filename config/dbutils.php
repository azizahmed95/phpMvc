<?php

	function DbConnect($hostname,$user,$pass,$dbname)
	{

		$returnArr = array();

		$conn = @mysqli_connect($hostname,$user,$pass);

		if(!$conn){

			$returnArr["errCode"] = 5;
			$returnArr["errMsg"] = "Could not connect to database" . mysqli_error();
		}
		else
		{
			if(!mysqli_select_db($conn,$dbname)){
				//print_r('error');

				$returnArr["errCode"] = 6;
				$returnArr["errMsg"] = "Could not connect to database" . mysqli_error();

			}else{
				//print_r('success');

				$returnArr["errCode"] = -1;
				$returnArr["errMsg"] = $conn;
			}
		}

		return $returnArr;

	}

	function runQuery($query,$conn)
	{

		$returnArr = array();

		$result = mysqli_query($conn,$query);			//$conn and $query is the parameter passed to the function runQuery()

		if(!$result)
		{
			$returnArr["errCode"] = 5;
			$returnArr["errMsg"] = "Query Failed : ".mysqli_error($conn);
			$returnArr["query"] = $query;
		}
		else
		{
			$returnArr["errCode"] = -1;
			$returnArr["errMsg"] = "Query Success!";
			$returnArr["dbResource"] = $result;
		}

		return $returnArr;

	}


?>