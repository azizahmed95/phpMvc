<?php

	$id = $_GET['id'];

	// echo $id;
	include("../config/config.php");			
	include("../config/dbutils.php");


	$returnArr = array();

	$connAdmin = DbConnect($host,$user,$pass,$dbname);			

	if(noError($connAdmin))
	{
		$connAdmin = $connAdmin["errMsg"];
	}
	else
	{
		printArr($connAdmin["errMsg"]);die;
	}

	$select_data = "select * from register where id = $id";


	$run_select = runQuery($select_data,$connAdmin);

	if(noError($run_select))
	{

		while($row = mysqli_fetch_array($run_select["dbResource"]))
		{
			$rid = $row['id'];
			$fname = $row["firstname"];
			$lname = $row["lastname"];
			$email = $row["email"];
			$contact = $row['contact'];
			$addr1 = $row['address1'];
			$addr2 = $row['address2'];
			$country = $row['country'];
			$state = $row['state'];
			$city = $row['city'];
			$pin = $row['pincode'];

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Edit Details</title>

		<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>

		<link rel="stylesheet" href="css/bootstrap.min.css"></script>
		
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>		<!-- used for closing alert -->

		<script type="text/javascript" src="js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	</head>

	<body style="background:#eee;color:#000;">

	<?php include("../config/navigationBar.php");?>

		<br><br>

		<br>

		<div class="container-fluid">

		<p id="display" class="display-5 text-success text-lg" align="center"></p>

		 <div class="row"><div class="col-md-3"></div>

		<form method="post" id="demoform" class="col-md-5">

		<h2 class="display-7 text-info">Edit Details</h2>

		 <div class="form-group">

		 <div class="row">
	 		<div class="col-md-6">
			<label for="fname">First Name :</label>
		 	<input type="text" name="fname" id="fname" class="form-group form-control" value="<?php echo $fname; ?>" />
			</div>

			<div class="col-md-6">
			 <label for="fname">Last Name :</label> 
			 <input type="text" name="lname" id="lname" class="form-group form-control" value="<?php echo $lname; ?>"/>
			 </div>
		
		</div>

			<label for="fname">Email ID :</label> 
		 	<input type="text" name="email" id="email" class="form-group form-control" value="<?php echo $email; ?>" />

			<label for="fname">Contact No:</label>
	 		<input type="text" name="contact" id="contact" class="form-group form-control" value="<?php echo $contact; ?>"/>


	 	Address1: <input type="text" name="addr1" id="addr1" class="form-group form-control" value="<?php echo $addr1; ?>"/>
		

		Address2: <input type="text" name="addr2" id="addr2" class="form-group form-control" value="<?php echo $addr2; ?>"/>

		Country : <input type="text" name="country" id="country" class="form-group form-control" value="<?php echo $country; ?>" />
		

		State : <input type="text" name="state" id="state" class="form-group form-control" value="<?php echo $state; ?>" />
	

		City : <input type="text" name="city" id="city" class="form-group form-control" value="<?php echo $city; ?>"/>
		

		Pincode : <input type="text" name="pincode" id="pincode" class="form-group form-control" value="<?php echo $pin; ?>"/>



		<input type="button" name="submit" value="Update Details" class="btn btn-success col-md-12" 
				onclick="updateDetails(<?php echo $rid; ?>)" />

		</div>

		</form>

		</div>
		</div>

		

	</body>

</html>
<?php
	
	}

}

?>

<script type="text/javascript">
	
	function updateDetails(str)
	{
		var id = str;
		
		//alert(id);

		var fname 	= $("#fname").val();
		var lname 	= $("#lname").val();
		var email 	= $("#email").val();
		var contact = $("#contact").val();
		var addr1 	= $("#addr1").val();
		var addr2 	= $("#addr2").val();
		var country = $("#country").val();
		var state 	= $("#state").val();
		var city 	= $("#city").val();
		var pincode = $("#pincode").val();

		$.ajax({

			url : "../controller/mycontrol.php",
			
			type: "post",
			
			async: false,
			
			dataType : "json",
			
			data : {
				type  : "updateData" ,
				id 	  : 	id ,
				fname : fname,			
				lname : lname,
				email : email,
				contact: contact,
				addr1 : addr1,
				addr2 : addr2,
				country: country,
				state : state,
				city  : city,
				pincode: pincode 

			},

			success:function(data){

				console.log(data);
				alert(data);


					if(data["errCode"] == -1)
					{
						alert('Data Updated!');
						$("#display").html("Data Updated Successfully!");
					}
					else
					{
						$("#display").html('Data not Updated!');
					}
			}



		})


	}

</script> 

