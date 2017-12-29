<?php

	error_reporting(0);
	
	$host = "localhost";
	$user = "root";
	$pass= "dbuser@123";
	$dbname = "products";


	$logPath=$_SERVER['DOCUMENT_ROOT']."/test2/logfiles/";

	$addLogPath = $logPath."add/";
	$editLogPath = $logPath."edit/";

	//echo $logPath;

	function printArr($array){

		echo "<pre>";
			print_r($array);
		echo "</pre>";

	}


	function noError($arr){

		if($arr["errCode"] == -1)
			return true;
		else
			return false;
	}

	function cleanQueryParameter($conn,$string)
	{
		/*$string = trim($string);
		$string = addslashes($string);
		$string = mysqli_real_escape($conn,$string);   got error bcoz its mysqli_real_escape_string

		return $string;*/

		$string = trim($string);
	    $string = addslashes($string);
	    $string = mysqli_real_escape_string($conn,$string);

	    return $string;

	}

	function cleanXSS($string)
	{
		//htmlspecialchars(input_string,quote_style,character_set)

    	return htmlspecialchars($string,ENT_QUOTES,'UTF-8');
	}

?>