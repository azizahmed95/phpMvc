<?php

	include("../config/config.php");			
	include("../config/dbutils.php");
/*	include("../controller/deleteRecords.php");*/



	$returnArr = array();

	$connAdmin = DbConnect($host,$user,$pass,$dbname);			//parameters inside this are variables of config file


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

	$pageno = $_GET['page'];


	$resultperpage = 5;
	
	$startpage = ($pageno -1) * $resultperpage;

	$select_query = "select * from register";

	$run_select = runQuery($select_query,$connAdmin);


	$totalrows = mysqli_num_rows($run_select['dbResource']);

	echo $totalrows;

	echo "<br>";
	
	$lastpage = $totalrows/$resultperpage;
	$lastpage = ceil($lastpage);
	
	echo $lastpage;


	if(isset($_GET['page']))
	{
		$pageno = $_GET['page'];
	}
	else
	{
		$pageno = 1;
	}
/*rvftuk
bfvh
uhbfyy8
hfgyg*/

	if($pageno<=1)
	{
		$pageno = 1;
	}
	else if($pageno > $lastpage)
	{
		$pageno = $lastpage;
	}


	if(!isset($_GET["page"]) || ($_GET["page"]==1 ))
	{
		$startpage = 0;
	}
	else
	{
		$startpage = $startpage;
	}

?>
<!DOCTYPE html>

<html>
	<head>
		<title>Register MVC</title>

		<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>

		<link rel="stylesheet" href="css/bootstrap.min.css"></script>
		
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>		<!-- used for closing alert -->

		<script type="text/javascript" src="js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		
		<style type="text/css">
			
			.btn
			{
				cursor:pointer;
			}

		</style>


	</head>

	<body style="background:#eee;color:#000;">

	<?php include("../config/navigationBar.php");?>


	<br><br><br>


<div class="container-fluid" align="center">

		<h1 class="display-4 text-info">Registered Users</h1>


		<div class="col-md-10">
		<table class="table table-dark table-striped">
			<tr class="table-success"  style="color:#000;" align="center">
				<th>Register Id</th>
				<th>FirstName</th>
				<th>LastName</th>
				<th>Email Id</th>
				<th>Contact</th>
				<th>Address1</th>
				<th>Address2</th>
				<th>Country</th>
				<th>State</th>
				<th>City</th>
				<th>Pincode</th>
				<th colspan="2" class="bg-primary text-white">Actions</th>
				

			</tr>



<?php

	


	//printArr($connAdmin);




	$select_query = "select * from register limit $startpage,$resultperpage";

	$run_select = runQuery($select_query,$connAdmin);


	if(noError($run_select))
	{
		//printArr($run_select) will print both code and msg and $run_select['errmsg'] only print msg

		//printArr($run_select['errMsg']);

		while($row = mysqli_fetch_array($run_select["dbResource"]))
		{
			$rid = $row['id'];
			$fname = $row['firstname'];
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
		<tr  align="center">
			<td><?php echo $rid; ?></td>
			<td><?php echo $fname; ?></td>
			<td><?php echo $lname; ?></td>
			<td><?php echo $email; ?></td>
			<td><?php echo $contact; ?></td>
			<td><?php echo $addr1; ?></td>
			<td><?php echo $addr2; ?></td>
			<td><?php echo $country; ?></td>
			<td><?php echo $state; ?></td>
			<td><?php echo $city; ?></td>
			<td><?php echo $pin; ?></td>
			<td>
				<a href="editDetails.php?id=<?php echo $rid; ?>">
				  <button type="button" class="btn btn-primary btn-sm">
						<i class="fa fa-pencil-square-o fa-2x"></i>
					</button>
				</a>
			
			</td>

			
			<td>
			
			 <a href="viewDetails.php">
			
			 <button type="button" class="btn btn-danger btn-sm" onclick="deleteData(<?php echo $rid; ?>)">
	          		<span class="fa fa-trash-o fa-2x red-icon"></span>
	       	 </button>

	       	 </a>
       		
			</td>

<?php

			//echo json_encode(printArr($row['firstname']));
		}
	}
	else
	{
		printArr($run_select);
	}

?>	
			</tr>

		</table>


	<ul class="pagination pagination-md">
	<?php
		if($pageno > 1)
		{
	?>
    	<li class="page-item"><a class="page-link" href="?page=<?php echo ($pageno-1); ?>">Previous</a></li>
    <?php
    	}

    	for($i=1;$i<=$lastpage;$i++)
    	{
    ?>
    	<li class="page-item"><a class="page-link" href="#"><?php echo $i; ?></a></li>
    <?php
    	}
    	?>


    	<li class="page-item"><a class="page-link" href="?page=<?php echo ($pageno+1); ?>">Next</a></li>
  	</ul>


		<p id="display"></p>

	</div>
</div>

	
</body>
</html>

<script type="text/javascript">
	
	function deleteData(str)
	{
		var id = str;
		
		//alert(id);

		if (confirm("Are you sure you want to delete")) 
		{

			$.ajax({

				url : "../controller/mycontrol.php",
				
				type: "POST",
				
				data: 
				{
						 uid  : id,				//uid will be posted in controller file
						 type : "deleteData"
				},
				
				dataType : "html",

				success:function(data){

					if(data == "success")
					{
						alert('Deleted!');
						$("#display").html("Data Deleted Successfully!");
					}
					else
					{
						$("#display").html('Data not deleted!');
					}
				}

			});

		}

	}

</script>