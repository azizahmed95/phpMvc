<!-- <?php echo $_SERVER['PHP_SELF'];

			echo "<br>";
			
			echo $_SERVER['SERVER_NAME'];

			echo "<br>";
			
			echo $_SERVER['HTTP_HOST'];
			
			echo "<br>";
			echo $_SERVER['HTTP_REFERER'];
			
			echo "<br>";
			echo $_SERVER['HTTP_USER_AGENT'];

			echo "<br>";
			echo $_SERVER['SCRIPT_NAME'];

			echo $_SERVER['SERVER_ADDR'];		//returns the ip address of the host server

?> -->
<?php 
			include("../config/config.php");			
			include("../config/dbutils.php");


		 	$connAdmin = DbConnect($host,$user,$pass,$dbname);
		 	
			if(noError($connAdmin))
			{
				$connAdmin = $connAdmin["errMsg"];
			}
			else
			{
				printArr($connAdmin["errMsg"]);die;
				
			}


?>

<!DOCTYPE html>

<html>
	<head>
		<title>Register MVC</title>

		<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>

		<link rel="stylesheet" href="css/bootstrap.min.css"></script>
		
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>	
		  <!-- used for closing alert -->

		<script type="text/javascript" src="js/bootstrap.min.js"></script>

		<style type="text/css">
			
			.btn
			{
				cursor:pointer;
			}

		</style>

	</head>

	<body style="background:#eee;color:#000;">

		<?php include("../config/navigationBar.php");?>

		<br><br>
	
		<br>


		<div class="container-fluid">


		<p id="display" align="center"></p>

		 <div class="row"><div class="col-md-3"></div>

		<form method="post" id="demoform" name="demoform" class="col-md-5" enctype="multipart/form-data">

		<h2 class="display-7 text-info">Register Form using MVC</h2>

		<?php  ?>


		 <div class="form-group">

		 <div class="row">


	 		<div class="col-md-6">
			<label for="fname">First Name :</label>
		 	<input type="text" name="fname" id="fname" class="form-group form-control" placeholder="Enter FirstName" required="required"/>
			</div>

			<div class="col-md-6">
			<label for="fname">Last Name :</label> 
			 <input type="text" name="lname" id="lname" class="form-group form-control" placeholder="Enter LastName"/>
			 </div>

		</div>
		
			<label for="fname">Email ID :</label> 
		 	<input type="text" name="email" id="email" class="form-group form-control" placeholder="Enter Email ID" />

			<label for="fname">Contact No:</label>
	 		<input type="text" name="contact" id="contact" class="form-group form-control" placeholder="Enter Contact number"/>

		Address1: <input type="text" name="addr1" id="addr1" class="form-group form-control" placeholder="Enter Address1"/>
		

		Address2: <input type="text" name="addr2" id="addr2" class="form-group form-control" placeholder="Enter Address1"/>
		
		

		Country : 
	
		<!-- <input type="text" name="country" id="country" class="form-group form-control" placeholder="Enter your country"/> -->
	<div class="form-group">
			  <select class="form-control" id="country" name="country" onchange="getStates(this.value)">
			  	
			  	<option value="">Select a Country</option>
		<?php


			$sel_country = "select * from country";

			$run_query = runQuery($sel_country,$connAdmin);

		if(noError($run_query))
		{
		
			while($row = mysqli_fetch_array($run_query["dbResource"]))
			{

				$countr_id = $row['cid'];
				$countr_name = $row['cname'];

		?>

		  	<option value="<?php echo $countr_id; ?>"><?php echo $countr_name; ?></option>
		
			<?php

			}
		}

		else
		{
			//printArr($run_query);
			echo '<option value=0>"'.mysqli_error($connAdmin).'"</option>';
		}
?>
		  </select>

		</div>


		State : 

		<div class="form-group">
			
			<select class="form-control" id="state" name="state" onchange="changeCities(this.value)">
			  	
			  	<option value="">Select a State</option>

	<!-- 	<?php

			$sel_states = "select * from states";

			$run_query = runQuery($sel_states,$connAdmin);

		if(noError($run_query))
		{
			
			while($row = mysqli_fetch_array($run_query['dbResource']))
			{
					$sid = $row['sid'];
					$sname = $row['state_name'];
		?>
				<option value="<?php echo $sid;?>"><?php echo $sname; ?></option>
		<?php

				}
			}
		?>
 -->
			</select>

		</div>	

		City : 

		<!-- <input type="text" name="city" id="city" class="form-group form-control" placeholder="Enter your city"/> -->
		
		<div class="form-group">
		
			<select class="form-control" id="city" name="city">
			  	
			  	<option value="">Select a City</option>

			</select>

		</div>


		Pincode : <input type="text" name="pincode" id="pincode" class="form-group form-control" placeholder="Enter pincode"/>

		Upload Image: <input type="file" name="myimg" id="myimg" class="form-group form-control">

		<input type="button" name="submit" value="Register" onclick="Register()" class="btn btn-danger col-md-12"/>

		<input type="hidden" name="type" value="register">		<!-- assigns a type as register -->

		</div>

		</form>


		</div>

		</div>

	</body>


	<script>
		
		// function Register()
		// {

		// 	var fname = $("#fname").val();
		// 	var lname = $("#lname").val();
		// 	var email = $("#email").val();
		// 	var contact = $("#contact").val();
		// 	var addr1 = $("#addr1").val();
		// 	var addr2 = $("#addr2").val();
		// 	var country = $("#country").val();
		// 	var state = $("#state").val();
		// 	var city = $("#city").val();
		// 	var pincode = $("#pincode").val();
		// 	var myimg = $("#myimg").val();

		// 	alert(myimg);

		// 		$.ajax({

		// 			url: "../controller/mycontrol.php",
		// 			type: "POST",
		// 			async:false,
		// 			//data : formData,

		// 			dataType : "html",
		// 			data : {
		// 				type: "register",
		// 				fname : fname,			//name : id pair
		// 				lname : lname,
		// 				email : email,
		// 				contact: contact,
		// 				addr1 : addr1,
		// 				addr2 : addr2,
		// 				country: country,
		// 				state : state,
		// 				city  : city,
		// 				pincode: pincode,
		// 				myimg : myimg
		// 			},

		// 			success: function(data){

		// 				console.log(data);
		// 				alert(data);
						
		// 			//	$("#display").html(data);

		// 				if(data == "Registration success")	
		// 				{
		// 					/*$("#display").html("Register success from register php file");*/	

		// 					$("#display").html('<div class="alert alert-success alert-dismissable col-md-8">'
		// 										+'<button type="button" class="close" data-dismiss="alert">&times;</button>'
		// 										+'<strong>Registered Successfully!</strong></div>');
							
		// 					document.getElementById('fname').value = "";
		// 					document.getElementById('lname').value = "";
		// 					document.getElementById('email').value = "";
		// 					document.getElementById('contact').value = "";
		// 					document.getElementById('addr1').value = "";
		// 					document.getElementById('addr2').value = "";
		// 					document.getElementById('country').value = "";
		// 					document.getElementById('state').value = "";
		// 					document.getElementById('city').value = "";
		// 					document.getElementById('pincode').value = "";

		// 				}
		// 				else
		// 				{
		// 					$("#display").html('Error from register php file');
		// 				}
						
		// 			}

		// 		});
			
		// }


function Register() {
	// alert('clicked');
	
        var formData = new FormData($('#demoform')[0]);			//for sending all values of form data as well as file or images
        
        alert(formData);

        $.ajax({
            url: "../controller/mycontrol.php",
            type: "POST",
            data: formData,
            dataType : "json",
            async: false,
            
            success: function (msg) {
               
                console.log(msg);

                alert(msg["errMsg"]);

                	if(msg["errCode"] == -1)	
					{

							//alert(msg);
							$("#display").html('<div class="alert alert-success alert-dismissable col-md-8">'
												+'<button type="button" class="close" data-dismiss="alert">&times;</button>'
												+'<strong>Registered Successfully!</strong></div>');
							
							document.getElementById('fname').value = "";
							document.getElementById('lname').value = "";
							document.getElementById('email').value = "";
							document.getElementById('contact').value = "";
							document.getElementById('addr1').value = "";
							document.getElementById('addr2').value = "";
							document.getElementById('country').value = "";
							document.getElementById('state').value = "";
							document.getElementById('city').value = "";
							document.getElementById('pincode').value = "";
							document.getElementById('myimg').value = "";
					}
					else
					{
							$("#display").html('<div class="alert alert-danger alert-dismissable col-md-8">'
												+'<button type="button" class="close" data-dismiss="alert">&times;</button>'
												+'<strong>Registration Failed!</strong></div>');
					}
						
            },
            cache: false,
            contentType: false,
            processData: false
        });
  
}


function getStates(val)
{
	var sid = val;

	//alert(sid);

	$.ajax({

		url : "../controller/mycontrol.php",
		type : "POST",
		dataType : "html",
		data : { 

			type 		: "changeState",
			state_id	: sid
		},

		success : function(data){
 			
 			$("#state").html(data);

		}
	});
}


function changeCities(val)
{
	var cid = val;

	//alert(sid);

	$.ajax({

		url : "../controller/mycontrol.php",
		type : "POST",
		dataType : "html",
		data : { 

			type 		: "changeCities",
			city_id		: cid
		},

		success : function(data){
 			
 			$("#city").html(data);

		}
	});
}


</script> 

	
</body>
</html>
