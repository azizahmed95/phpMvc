<?php

	function insertfunc($post_arr,$conn)
	{
		$returnArr = array();

		$file_name = $_FILES['myimg']['name'];
		$file_tmp = $_FILES['myimg']['tmp_name'];


		//$img = $file_name;

		/*echo $im."<br>";*/

		/*$img = stripslashes($file_name);*/


		move_uploaded_file($_FILES['myimg']['tmp_name'],"../view/images/".$_FILES['myimg']['name']);


		$reg_query = "INSERT INTO register(firstname,lastname,email,contact,address1,address2,country,state,city,pincode,images)
					  VALUES('".$_POST['fname']."','".$_POST['lname']."','".$_POST['email']."','".$_POST['contact']."',
					  '".$_POST['addr1']."','".$_POST['addr2']."',
					  '".$_POST['country']."','".$_POST['state']."','".$_POST['city']."','".$_POST['pincode']."',
					  '$file_name')";

		$run_query = runQuery($reg_query,$conn);  

		//printArr($reg_query);

		//$conn variable in this is a parameter passed to function insertfunc and not database $conn varaiable

		//$run_query = mysqli_query($conn,$reg_query);

		//printArr($reg_query);
		//printArr($run_query);die();

		if(noError($run_query))			//if arrCode is -1 then success else fail
		{
			//printArr($run_query);
			$returnArr["errCode"] = -1;
			$returnArr["errMsg"] = "Registered Successfully!";
			$returnArr["query"] = $reg_query;
		}
		else
		{
			//printArr($run_query);
			$returnArr["errCode"] = 5;
			$returnArr["errMsg"] = "Registration Failed!" . mysqli_error($conn);
			$returnArr["query"] = $reg_query;
		}

		return $returnArr;

	}

	function deletefunc($id,$conn)
	{
		$returnArr = array();

		//echo "hello from delete function";

		$delete_query = "delete from register where id=$id";

		$run_query = runQuery($delete_query,$conn);

		if(noError($run_query))
		{
			$returnArr["errCode"] = -1;
			$returnArr["errMsg"] = "Data Deleted Successfully!";
		}
		else
		{
			$returnArr["errCode"] = 6;
			$returnArr["errMsg"] = "Data not Deleted!";
			$returnArr["query"] = $run_query;
		}

		return $returnArr;
	}

	function updatefunc($id,$conn)
	{
		$returnArr = array();

		$update_query = "update register set firstname='".$_POST['fname']."',lastname='".$_POST['lname']."',email = '".$_POST['email']."',contact='".$_POST['contact']."',address1='".$_POST['addr1']."',address2='".$_POST['addr2']."',country='".$_POST['country']."',state='".$_POST['state']."',city='".$_POST['city']."',pincode='".$_POST['pincode']."'
			where id = '$id'";

		$run_query = runQuery($update_query,$conn);

		if(noError($run_query))
		{
			$returnArr["errCode"] = -1;
			$returnArr["errMsg"] = "Data Updated Successfully!";
			$returnArr["query"] = $update_query;
		}
		else
		{
			$returnArr["errCode"] = 6;
			$returnArr["errMsg"] = "Data not Updated!";
			$returnArr["query"] = $update_query;
		}

		return $returnArr;
	}


?>