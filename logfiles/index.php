<?php
	require '../../../../config/config.php';
	require '../../../../config/authenticationUtilities.php';
	require '../../../../config/dbUtilities.php';
	require '../../../../config/errorMap.php';


	require_once('../../../../core/xmlProcessor.php');
    require_once('../../../../core/logsCoreFunctions.php');

	header('Content-type: application/json');

	$connAdmin = "";
    /*---------------------- Connection With Database ---------------------------------*/
    $connAdmin = createDbConnection($host, $db_username, $db_password, $dbName);
    if (noError($connAdmin)) {
        $connAdmin = $connAdmin["errMsg"];
    } else {
        printArr("Database Error admin");
        exit;
    }


	$returnArr = array();
	$extraArg=array();
	$post_array = array();

	$file_path = $logDeviceRegistration;
	$xmlfilename="deviceRegistration.xml";

	/*Log initialization start*/ 
    $xmlArray = initializeXMLLog("Device Registration","app");
    $xmlProcessor =new xmlProcessor();

    //--------------------------------1. Start XML Log------------------------------------------------------
    $xml_data['request']["data"]='';
    $xml_data['request']["attribute"]=$xmlArray["request"];

    $logMsg = "Device Registration process start.";
	$xml_data['step1']["data"] = "1. {$logMsg}";
	

	foreach ($_POST as $key => $value) {
		$post_array[$key] = cleanQueryParameter($connAdmin,cleanXSS($value));
	}

	$logMsg = "Getting request parameters for Success.";
    $xml_data["step2"]["data"] = "2. {$logMsg}";

    $xml_data['parameters']["data"]="";
    $xml_data['parameters']["attributes"]=$post_array;

	//-------------------------------------------Required field validation--------------------------------

	if($post_array["deviceId"] == ""){
		$returnArr = setErrorStack($returnArr, 11, null, $extraArg);
		//$returnArr = getFormatedMessage(1001, array(0=>"deviceId"), $returnArr);

		//------------------------------------------------------------

		$logMsg = "Device Id field is required.";
	    $xml_data["step3"]["data"] = "3. {$logMsg}";

	    $xml_data['response']["data"]="";
    	$xml_data['response']["attributes"]=$returnArr;

		$xmlProcessor->writeXML($xmlfilename, $file_path, $xml_data, $xmlArray["activity"]);

		//------------------------------------------------------------

		http_response_code(422);
		closeDBConnection($connAdmin);
		echo json_encode($returnArr, JSON_PRETTY_PRINT);
		exit;
	}

	if($post_array["platform"] == ""){
		$returnArr = setErrorStack($returnArr, 12, null, $extraArg);
		//$returnArr = getFormatedMessage(1001, array(0=>"platform"), $returnArr);

		//------------------------------------------------------------

		$logMsg = "Platform field is required.";
	    $xml_data["step3"]["data"] = "3. {$logMsg}";

	    $xml_data['response']["data"]="";
    	$xml_data['response']["attributes"]=$returnArr;

		$xmlProcessor->writeXML($xmlfilename, $file_path, $xml_data, $xmlArray["activity"]);

		//------------------------------------------------------------

		http_response_code(422);
		closeDBConnection($connAdmin);
		echo json_encode($returnArr, JSON_PRETTY_PRINT);
		exit;
	}

	//----------------------------------------------------------------------------------------------------

	$post_array['deviceSalt']=generateSalt();
	$post_array['devicePublicKey'] = encryptPassword($post_array['manufacturer'],$post_array['deviceSalt']);
	$post_array['devicePrivateKey'] = encryptPassword($post_array['deviceId'],$post_array['deviceSalt']);


	$device_query = "SELECT * FROM deviceInfo WHERE deviceId='".$post_array['deviceId']."'";
	$device_result = runQuery($device_query, $connAdmin);

	$logMsg = "Get device information from table.";
	$xml_data["step3"]["data"] = "3. {$logMsg}";

	$xml_data['select_query']["data"]="";
    $xml_data['select_query']["attributes"]=$device_query;

	if(noError($device_result)){
		$row_count = $device_result["dbResource"]->num_rows;

		$logMsg = "Check device result count.";
		$xml_data["step4"]["data"] = "4. {$logMsg}";

		$xml_data['row_count']["data"]="";
    	$xml_data['row_count']["attributes"]=$row_count;

		if($row_count == 0){
			$query = "INSERT INTO deviceInfo ( `deviceId`, 
													`model`, 
													`platform`, 
													`manufacturer`, 
													`version`, 
													`serial`, 
													`deviceSalt`, 
													`devicePublicKey`, 
													`devicePrivateKey`,
													`createdOn`, 
													`updatedOn`) VALUES 
													(
														'".$post_array['deviceId']."',
														'".$post_array['model']."',
														'".$post_array['platform']."',
														'".$post_array['manufacturer']."',
														'".$post_array['version']."',
														'".$post_array['serial']."',
														'".$post_array['deviceSalt']."',
														'".$post_array['devicePublicKey']."',
														'".$post_array['devicePrivateKey']."',
														'".date("Y-m-d H:i:s")."',
	                                                	'".date("Y-m-d H:i:s")."'
													)";
				$result = runQuery($query, $connAdmin);

				//-------------------------------------------------------

				$logMsg = "Insert new device into table.";
				$xml_data["step5"]["data"] = "5. {$logMsg}";

				//$xml_data['insert_query']["data"]="";
			    $xml_data['insert_query']["attributes"]=$query;

				//-------------------------------------------------------

				if(noError($result)){

					$extraArg["devicePublicKey"] = $post_array['devicePublicKey'];
					$extraArg["devicePrivateKey"] = $post_array['devicePrivateKey'];

					


					//------------------------------------------------------------

					$logMsg = "Insert Successfully.";
				    $xml_data["step6"]["data"] = "6. {$logMsg}";

				    

					//------------------------------------------------------------


					/*
						Insert the new row for uninstall analytics 
					*/

					$uninstall_query = "INSERT INTO uninstallAnalytics (
																			`deviceId`,
																			`noOfTimesUpdated`,
																			`platform`,
																			`createdOn`,
																			`updatedOn`
																		) VALUES (
																			'".$post_array['deviceId']."',
																			'0',
																			'".$post_array['platform']."',
																			'".date("Y-m-d H:i:s")."',
																			'".date("Y-m-d H:i:s")."'
																		)";
					$uninstall_result = runQuery($uninstall_query, $connAdmin);

					$logMsg = "Insert new device into uninstall analytics table.";
					$xml_data["step7"]["data"] = "7. {$logMsg}";

			    	$xml_data['uninstall_query']["attributes"]=$uninstall_query;

					/*$extraArg["analytics_result"] = $uninstall_result;
					$extraArg["analytics_query"] = $uninstall_query;*/

					$returnArr = setErrorStack($returnArr, -1, null, $extraArg);

					$xml_data['response']["data"]="";
			    	$xml_data['response']["attributes"]=$returnArr;

					$xmlProcessor->writeXML($xmlfilename, $file_path, $xml_data, $xmlArray["activity"]);

					http_response_code(200);
					closeDBConnection($connAdmin);
					echo json_encode($returnArr, JSON_PRETTY_PRINT);
				}else{
					$extraArg["query"] = $query;
					$returnArr = setErrorStack($returnArr, 3, null, $extraArg);


					//------------------------------------------------------------

					$logMsg = "Error to insert details.";
				    $xml_data["step6"]["data"] = "6. {$logMsg}";

				    $xml_data['response']["data"]="";
			    	$xml_data['response']["attributes"]=$returnArr;

					$xmlProcessor->writeXML($xmlfilename, $file_path, $xml_data, $xmlArray["activity"]);

					//------------------------------------------------------------

					http_response_code(400);
					closeDBConnection($connAdmin);
					echo json_encode($returnArr, JSON_PRETTY_PRINT);
				}
		}else{
			$row = mysqli_fetch_assoc($device_result["dbResource"]);

			$extraArg["devicePublicKey"] = $row['devicePublicKey'];
			$extraArg["devicePrivateKey"] = $row['devicePrivateKey'];

			

			$query = "UPDATE deviceInfo SET updatedOn = '".date("Y-m-d H:i:s")."' WHERE id = ".$row['id'];
			$result = runQuery($query, $connAdmin);


			$uninstall_query = "UPDATE uninstallAnalytics SET noOfTimesUpdated = 0,updatedOn = '".date("Y-m-d H:i:s")."'  WHERE deviceId = '".$post_array['deviceId']."'";
			$uninstall_result = runQuery($uninstall_query, $connAdmin);

			/*$extraArg["analytics_result"] = $uninstall_result;
			$extraArg["analytics_query"] = $uninstall_query;*/

			$returnArr = setErrorStack($returnArr, -1, null, $extraArg);


			//------------------------------------------------------------

			$logMsg = "Device already exits and update the result.";
		    $xml_data["step5"]["data"] = "5. {$logMsg}";

		    $xml_data['insert_query']["attributes"]=$query;

		    $logMsg = "Updated Successfully.";
			$xml_data["step6"]["data"] = "6. {$logMsg}";

			$logMsg = "Update device info into uninstall analytics table.";
			$xml_data["step7"]["data"] = "7. {$logMsg}";

	    	$xml_data['uninstall_query']["attributes"]=$uninstall_query;

		    $xml_data['response']["data"]="";
	    	$xml_data['response']["attributes"]=$returnArr;

			$xmlProcessor->writeXML($xmlfilename, $file_path, $xml_data, $xmlArray["activity"]);

			//------------------------------------------------------------

			http_response_code(200);
			closeDBConnection($connAdmin);
			echo json_encode($returnArr, JSON_PRETTY_PRINT);
		}
	}

	
?>