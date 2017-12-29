<?php
require_once("dbController.php");
$db_handle = new DBController();
$query ="SELECT * FROM language";
$results = $db_handle->runQuery($query);
?>

<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<head>
		
		<script type="text/javascript" src="state.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<style>
* {
    box-sizing: border-box;
}
.row::after {
    content: "";
    clear: both;
    display: block;
}
[class*="col-"] {
    float: left;
    padding: 15px;
}
html {
    font-family: "Lucida Sans", sans-serif;
}
    padding: 0;

/* For desktop: */
.col-1 {width: 8.33%;}
.col-2 {width: 16.66%;}
.col-3 {width: 25%;}
.col-4 {width: 33.33%;}
.col-5 {width: 41.66%;}
.col-6 {width: 50%;}
.col-7 {width: 58.33%;}
.col-8 {width: 66.66%;}
.col-9 {width: 75%;}
.col-10 {width: 83.33%;}
.col-11 {width: 91.66%;}
.col-12 {width: 100%;}

@media only screen and (max-width: 500px) {
    /* For mobile phones: */
    [class*="col-"] {
        width: 100%;
    }
}
</style>
</head>
	<body>	
		<div id="div2" style="height:70px;margin-bottom:60px;">
			<p align="center" style="font-size:50px;font-family:cursive;color:orange;">VoiceUp</p>
		</div>
		<div id="div1" class="col-12">
		<form method="POST" id="f1" action="">
			<table cellspacing="12" align="center">
				<tr>
					<th align="left">
						Mobile No 
					</th>
					<td>
						<input type="text" id="mobile" name="mobile">
					</td>
				</tr>
				<tr>
					<th align="left">
						First Name 
					</th>
					<td>
						<input type="text" id="fname" name="fname">
					</td>
				</tr>
				<tr>
					<th align="left">
						Last Name
					</th>
					<td>
						<input type="text" id="lname" name="lname">
					</td>
				</tr>
				<tr>
					<th align="left">
						Select Language 
					</th>
					<td>
						
						<select name="language" id="language" class="demoInputBox" onChange="getState(this.value);">
							<option value="">Select Language</option>
							<?php
							foreach($results as $language) {
							?>

							<option value="<?php echo $language["lang_id"]; ?>"><?php echo $language["name"]; ?></option>

							<?php
							}
							
							?>
					</td>
				</tr>
					<th align="left">
						Select State
					</th> 
					<td>
						<select name="state" id="state" class="demoInputBox" onChange="getCity(this.value);">
						<option value="">Select State</option>
						</select>
					</td>
				</tr>
				<tr>
					<th align="left">
						Select City
					</th>
					<td>
						<select name="city" id="city" class="demoInputBox" onChange="getTehsil(this.value);">
						<option value="">Select City</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<th align="left">
						Select Tehsil
					</th>
					<td>
						<select name="tehsil" id="tehsil" class="demoInputBox" onClick="setLink(this.value);">
						<option value="">Select Tehsil</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
					<input type="button" value="Submit" onclick="getSubscriber();"></td>
				</tr>
			</table>
			
			<div id="d1" align="center" class="col-12">
			</div>	
			</div>	
		</form>
		<script type="text/javascript">
			function getSubscriber()
			{
				var mobile=$("#mobile").val();
				var fname=$("#fname").val();
				var lname=$("#lname").val();
				//var language=$("#language").val();
				var state=$("#state").val();
				var city=$("#city").val();
				var tehsil=$("#tehsil").val();

				$.ajax({
					url:"subscriber.php",
					type:"POST",
					dataType:"html",
					//console.log()
					data:{
						"mobile":mobile,
						"fname":fname,
						"lname":lname,
						"state":state,
						"city":city,
						"tehsil":tehsil
					},

					success: function(data)
					{
						//if(data=="success")
							alert(data);	
						//else
							//alert("Error");
					}
				});
			
			}
		</script>
	</body>
</html>