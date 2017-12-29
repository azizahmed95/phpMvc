<?php
	
	include("../config/config.php");			
	include("../config/dbutils.php");
	include("../model/allQueries.php");

	//note do not use printArr() for any sql query related operations or for $_POST in this file

	//use type as a post to check whether to add,delete or update the data

 	$post_arr = array();

 	$connAdmin = DbConnect($host,$user,$pass,$dbname);
 	
	if(noError($connAdmin))
	{
		$connAdmin = $connAdmin["errMsg"];
		//printArr($connAdmin);
		/*$returnArr["errCode"] = -1;
		$returnArr["errMsg"] = "Connection success!";
		printArr($returnArr);*/
	}
	else
	{
		printArr($connAdmin["errMsg"]);die;
		
		/*$returnArr["errCode"] = 6;
		$returnArr["errMsg"] = "Connection Failed!";
		printArr($returnArr);*/
	}

	//printArr($_POST);			
	
	/*	for posting whole data of inputs in the page
	*/
	$returnArr = array();
	$extraArg=array();

	if($_POST['type'] == "register")
	{

	$post_array = array();

	$file_path = $log_path;
	$xmlfilename="Logs.xml";

	/*Log initialization start*/ 
    $xmlArray = initializeXMLLog("Device Registration","app");
    $xmlProcessor =new xmlProcessor();

    //--------------------------------1. Start XML Log------------------------------------------------------
    $xml_data['request']["data"]='';
    $xml_data['request']["attribute"]=$xmlArray["request"];

    $logMsg = "Device Registration process start.";
	$xml_data['step1']["data"] = "1. {$logMsg}";
	

		foreach ($_POST as $key => $value) {
			
			$post_arr[$key] = cleanQueryParameter($connAdmin,cleanXSS($value));			//here $value represents single value 
		}
	$logMsg = "Getting request parameters for Success.";
    $xml_data["step2"]["data"] = "2. {$logMsg}";

    $xml_data['parameters']["data"]="";
    $xml_data['parameters']["attributes"]=$post_array;


		$result = insertfunc($post_arr,$connAdmin);


				//-------------------------------------------------------

				$logMsg = "Insert new device into table.";
				$xml_data["step5"]["data"] = "5. {$logMsg}";

				//$xml_data['insert_query']["data"]="";
			    $xml_data['insert_query']["attributes"]=$result;

		//printArr($result);
			    $var="Registration success";
		if(noError($result))
		{
			echo $var;


			//printArr($result);  //note : do not use printArr function in this bcoz only we have to pass 'success' to the register.php file
		}
		else
		{
			printArr($result);
					
			echo "Registration Failed";
		}
		$xmlProcessor->writeXML($xmlfilename, $file_path, $xml_data, $xmlArray["activity"]);  //create xml log file

		echo json_encode($var);

	}

	if($_POST['type'] == "deleteData")
	{
		$id = $_POST['uid'];					

		//echo $id;

		$result = deletefunc($id,$connAdmin);

		if(noError($result)){
			echo "success";
		}
		else
		{
			echo "Failed!";
		}

	}

	if($_POST['type'] == "updateData")
	{

		$id = $_POST['id'];

		$result = updatefunc($id,$connAdmin);

		if(noError($result))
		{
			echo "success";
		}
		else
		{
			echo "Failed!";
		}


	}

	if($_POST['type'] == "changeState")
	{
		$state_id = $_POST['state_id'];

		$select_states = "select * from states where cid = '$state_id'";

		$run_query = runQuery($select_states,$connAdmin);

		if(noError($run_query))
		{

?>
				<option value="">Select a State</option>

<?php

			while($row = mysqli_fetch_array($run_query['dbResource']))
			{
					$sid = $row['sid'];
					$sname = $row['state_name'];
?>

		<option value="<?php echo $sid;?>"><?php echo $sname; ?></option>

<?php

			}
		}

	}
	
if($_POST['type'] == "changeCities")
	{
		$city_id = $_POST['city_id'];

		$select_states = "select * from city where sid = '$city_id'";

		$run_query = runQuery($select_states,$connAdmin);

		if(noError($run_query))
		{

?>
				<option value="">Select a City</option>

<?php

			while($row = mysqli_fetch_array($run_query['dbResource']))
			{
					$id = $row['id'];
					$cname = $row['city_name'];
?>

		<option value="<?php echo $id;?>"><?php echo $cname; ?></option>

<?php

			}
		}

	}


?>