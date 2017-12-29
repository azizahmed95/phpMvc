<?php
	require_once('../config/config.php');
	require_once('../config/errorMap.php');

	require_once('../logs/xmlProcessor.php');
    require_once('../logs/logsCoreFunctions.php');


	$returnArr = array();
	$extraArg = array();

	if($_POST['type'] == "add_tower"){
		$post_array = array();

	$file_path = $logAddTower;
	$xmlfilename="addtower.xml";

	/*Log initialization start*/ 
    $xmlArray = initializeXMLLog("Device Registration","app");
    $xmlProcessor =new xmlProcessor();

    //--------------------------------1. Start XML Log------------------------------------------------------
    $xml_data['request']["data"]='';
    $xml_data['request']["attribute"]=$xmlArray["request"];

    $logMsg = "Device Registration process start.";
	$xml_data['step1']["data"] = "1. {$logMsg}";

		foreach($_POST as $key => $value) {    
		    $post_array[$key] = cleanQueryParameter($connAdmin,cleanXSS($value)); 
		}

		$logMsg = "Getting request parameters for Success.";
    $xml_data["step2"]["data"] = "2. {$logMsg}";

    $xml_data['parameters']["data"]="";
    $xml_data['parameters']["attributes"]=$post_array;

    
		$query = "INSERT INTO towers (`tower_name`,
												`status`,
												`created_at`,
												`updated_at`
												) VALUES 
												(
													'".$post_array['tower_name']."',
													'".$post_array['status']."',
													'".date("Y-m-d H:i:s")."',
			                                        '".date("Y-m-d H:i:s")."'
												)";

		$logMsg = "Insert new device into table.";
				$xml_data["step3"]["data"] = "3. {$logMsg}";

				//$xml_data['insert_query']["data"]="";
			    $xml_data['insert_query']["attributes"]=$query;
			    //printArr($xml_data);
			    //die;
				
		$result = runQuery($query, $connAdmin);

		if(noError($result)){
			$returnArr = setErrorStack($query, -1, "Details Added.");
		}else{
			$returnArr = setErrorStack($query, 3, null, $extraArg);
			printArr($query);
		}

		$xmlProcessor->writeXML($xmlfilename, $file_path, $xml_data, $xmlArray["activity"]);

			//------------------------------------------------------------

		
			echo json_encode($returnArr);
	}

	if($_POST['type'] == "get_tower_data"){
		$id = $_POST['id'];

		$query = "SELECT * FROM towers WHERE id = ".$id;
		$result = runQuery($query, $connAdmin);

		$value = mysqli_fetch_assoc($result["dbResource"]);

?>
		<form id="edit" name="edit" action="javascript:;" class="form-horizontal form-label-left" data-parsley-validate="">
			<input type="hidden" name="id" value="<?php echo $value['id']; ?>">
			<div class="form-group">
  				<label class="control-label col-md-3 col-sm-3 col-xs-12">Tower Name<span class="required">*</span>
  				</label>
  				<div class="col-md-6 col-sm-6 col-xs-12">
    				<input type="text" name="tower_name"  class="form-control col-md-7 col-xs-12" data-parsley-trigger="keyup" data-parsley-maxlength="255" value="<?php echo $value['tower_name']; ?>" required="">
  				</div>
			</div>

			<div class="form-group">
  				<label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span>
  				</label>
  				<div class="col-md-6 col-sm-6 col-xs-12">
    				<select name="status" id="status" class="form-control" required="">
                        <option value="">Select Status...</option>
                        <option value="1" <?php if($value['status'] == 1){ echo "selected"; } ?>>Active</option>
                        <option value="0" <?php if($value['status'] == 0){ echo "selected"; } ?>>Inactive</option>
                    </select>
  				</div>
			</div>
			
			<div class="form-group">
  				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
    				<button type="reset" class="btn btn-primary" data-dismiss="modal">Cancel</button>
    				<button type="submit" class="btn btn-success">Update</button>
  				</div>
			</div>
		</form>

		<script type="text/javascript">
	    	$(function () {
			    $('form#edit').parsley().on('field:validated', function() {
			        var ok = $('.parsley-error').length === 0;
			        $('.bs-callout-info').toggleClass('hidden', !ok);
			        $('.bs-callout-warning').toggleClass('hidden', ok);
			    })
			    .on('form:submit', function() {
			        var formData = new FormData($("form#edit")[0]);
			        formData.append('type', 'edit_tower');

			        /*$(".hidden1").show(); 
			        $("body").addClass('waitMe_body');
			        $("body").addClass('hideMe');
			        $("#disablingDiv").show();*/

			        $.ajax({
			            type: "POST",
			            dataType: "json",
			            url: "../../controller/masterController.php",
			            data: formData,
			            //async: false,
			            cache: false,
			            contentType: false,
			            processData: false,
			            success: function(user) {
			                if(user["errCode"] == -1){
			                    var msg=user["errMsg"];
			                    bootbox.alert(msg, function() {
			                        location.reload();
			                    });
			                }else{
			                	var msg=user["errMsg"];
			                    bootbox.alert(msg, function() {
			                    });
			                }

			            },
			            error: function() {
			                bootbox.alert("Failed to update details.", function() {});
			            },
			            progress: function(e) {
			                if(e.lengthComputable) {
			                    //calculate the percentage loaded
			                    var pct = (e.loaded / e.total) * 100;

			                    //log percentage loaded
			                    //console.log(pct);
			                    $('#progress1').html(pct.toPrecision(3) + '%');
			                    $('#progress1').attr("aria-valuenow",pct.toPrecision(3) + '%');
			                    $('#progress1').css("width",pct.toPrecision(3) + '%');
			                }
			                //this usually happens when Content-Length isn't set
			                else {
			                    $("body").removeClass('waitMe_body');
			                    $("body").removeClass('hideMe');
			                    //console.warn('Content Length not reported!');
			                }
			            }
			        });
			    });
			});
	    </script>
<?php
	}

	if($_POST['type'] == "edit_tower"){
		foreach ($_POST as $key => $value) {
			$post_array[$key] = cleanQueryParameter($connAdmin,cleanXSS($value));
		}

		$query = "UPDATE towers SET tower_name = '".$post_array['tower_name']."', status = '".$post_array['status']."', updated_at = '".date("Y-m-d H:i:s")."' WHERE id=".$post_array['id'];
				
		$result = runQuery($query, $connAdmin);
		
		if(noError($result)){
			$returnArr = setErrorStack($query, -1, "Details Updated.", $extraArg);
		}else{
			$returnArr = setErrorStack($query, 3, null, $extraArg);
		}

		echo(json_encode($returnArr));
	}

	if($_POST['type'] == "delete_tower"){
		$query = "UPDATE towers SET status = 0, updated_at = '".date("Y-m-d H:i:s")."' WHERE id=".$_POST['id'];				
		$result = runQuery($query, $connAdmin);
		
		if(noError($result)){
			$returnArr = setErrorStack($query, -1, "Details Deleted.", $extraArg);
		}else{
			$returnArr = setErrorStack($query, 3, null, $extraArg);
		}

		echo(json_encode($returnArr));
	}

	if($_POST['type'] == "add_floor"){
		$post_array = array();
		foreach($_POST as $key => $value) {    
		    $post_array[$key] = cleanQueryParameter($connAdmin,cleanXSS($value)); 
		}

		$query = "INSERT INTO floors (`floor_name`,
												`status`,
												`created_at`,
												`updated_at`
												) VALUES 
												(
													'".$post_array['floor_name']."',
													'".$post_array['status']."',
													'".date("Y-m-d H:i:s")."',
			                                        '".date("Y-m-d H:i:s")."'
												)";
				
		$result = runQuery($query, $connAdmin);
		
		if(noError($result)){
			$returnArr = setErrorStack($query, -1, "Details Added.");
		}else{
			$returnArr = setErrorStack($query, 3, null, $extraArg);
			printArr($query);
		}

		echo(json_encode($returnArr));
	}


	if($_POST['type'] == "get_floor_data"){
		$id = $_POST['id'];

		$query = "SELECT * FROM floors WHERE id = ".$id;
		$result = runQuery($query, $connAdmin);

		$value = mysqli_fetch_assoc($result["dbResource"]);

?>
		<form id="edit" name="edit" action="javascript:;" class="form-horizontal form-label-left" data-parsley-validate="">
			<input type="hidden" name="id" value="<?php echo $value['id']; ?>">
			<div class="form-group">
  				<label class="control-label col-md-3 col-sm-3 col-xs-12">Floor Name<span class="required">*</span>
  				</label>
  				<div class="col-md-6 col-sm-6 col-xs-12">
    				<input type="text" name="floor_name"  class="form-control col-md-7 col-xs-12" data-parsley-trigger="keyup" data-parsley-maxlength="255" value="<?php echo $value['floor_name']; ?>" required="">
  				</div>
			</div>

			<div class="form-group">
  				<label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span>
  				</label>
  				<div class="col-md-6 col-sm-6 col-xs-12">
    				<select name="status" id="status" class="form-control" required="">
                        <option value="">Select Status...</option>
                        <option value="1" <?php if($value['status'] == 1){ echo "selected"; } ?>>Active</option>
                        <option value="0" <?php if($value['status'] == 0){ echo "selected"; } ?>>Inactive</option>
                    </select>
  				</div>
			</div>
			
			<div class="form-group">
  				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
    				<button type="reset" class="btn btn-primary" data-dismiss="modal">Cancel</button>
    				<button type="submit" class="btn btn-success">Update</button>
  				</div>
			</div>
		</form>

		<script type="text/javascript">
	    	$(function () {
			    $('form#edit').parsley().on('field:validated', function() {
			        var ok = $('.parsley-error').length === 0;
			        $('.bs-callout-info').toggleClass('hidden', !ok);
			        $('.bs-callout-warning').toggleClass('hidden', ok);
			    })
			    .on('form:submit', function() {
			        var formData = new FormData($("form#edit")[0]);
			        formData.append('type', 'edit_floor');

			        /*$(".hidden1").show(); 
			        $("body").addClass('waitMe_body');
			        $("body").addClass('hideMe');
			        $("#disablingDiv").show();*/

			        $.ajax({
			            type: "POST",
			            dataType: "json",
			            url: "../../controller/masterController.php",
			            data: formData,
			            //async: false,
			            cache: false,
			            contentType: false,
			            processData: false,
			            success: function(user) {
			                if(user["errCode"] == -1){
			                    var msg=user["errMsg"];
			                    bootbox.alert(msg, function() {
			                        location.reload();
			                    });
			                }else{
			                	var msg=user["errMsg"];
			                    bootbox.alert(msg, function() {
			                    });
			                }

			            },
			            error: function() {
			                bootbox.alert("Failed to update details.", function() {});
			            },
			            progress: function(e) {
			                if(e.lengthComputable) {
			                    //calculate the percentage loaded
			                    var pct = (e.loaded / e.total) * 100;

			                    //log percentage loaded
			                    //console.log(pct);
			                    $('#progress1').html(pct.toPrecision(3) + '%');
			                    $('#progress1').attr("aria-valuenow",pct.toPrecision(3) + '%');
			                    $('#progress1').css("width",pct.toPrecision(3) + '%');
			                }
			                //this usually happens when Content-Length isn't set
			                else {
			                    $("body").removeClass('waitMe_body');
			                    $("body").removeClass('hideMe');
			                    //console.warn('Content Length not reported!');
			                }
			            }
			        });
			    });
			});
	    </script>
<?php
	}

	if($_POST['type'] == "edit_floor"){
		foreach ($_POST as $key => $value) {
			$post_array[$key] = cleanQueryParameter($connAdmin,cleanXSS($value));
		}

		$query = "UPDATE floors SET floor_name = '".$post_array['floor_name']."', status = '".$post_array['status']."', updated_at = '".date("Y-m-d H:i:s")."' WHERE id=".$post_array['id'];
				
		$result = runQuery($query, $connAdmin);
		
		if(noError($result)){
			$returnArr = setErrorStack($query, -1, "Details Updated.", $extraArg);
		}else{
			$returnArr = setErrorStack($query, 3, null, $extraArg);
		}

		echo(json_encode($returnArr));
	}

	if($_POST['type'] == "delete_floor"){
		$query = "UPDATE floors SET status = 0, updated_at = '".date("Y-m-d H:i:s")."' WHERE id=".$_POST['id'];				
		$result = runQuery($query, $connAdmin);
		
		if(noError($result)){
			$returnArr = setErrorStack($query, -1, "Details Deleted.", $extraArg);
		}else{
			$returnArr = setErrorStack($query, 3, null, $extraArg);
		}

		echo(json_encode($returnArr));
	}



	if($_POST['type'] == "add_bedroom"){
		$post_array = array();
		foreach($_POST as $key => $value) {    
		    $post_array[$key] = cleanQueryParameter($connAdmin,cleanXSS($value)); 
		}

		$query = "INSERT INTO bedrooms (`bedroom_name`,
												`status`,
												`created_at`,
												`updated_at`
												) VALUES 
												(
													'".$post_array['bedroom_name']."',
													'".$post_array['status']."',
													'".date("Y-m-d H:i:s")."',
			                                        '".date("Y-m-d H:i:s")."'
												)";
				
		$result = runQuery($query, $connAdmin);
		
		if(noError($result)){
			$returnArr = setErrorStack($query, -1, "Details Added.");
		}else{
			$returnArr = setErrorStack($query, 3, null, $extraArg);
			printArr($query);
		}

		echo(json_encode($returnArr));
	}


	if($_POST['type'] == "get_bedroom_data"){
		$id = $_POST['id'];

		$query = "SELECT * FROM bedrooms WHERE id = ".$id;
		$result = runQuery($query, $connAdmin);

		$value = mysqli_fetch_assoc($result["dbResource"]);

?>
		<form id="edit" name="edit" action="javascript:;" class="form-horizontal form-label-left" data-parsley-validate="">
			<input type="hidden" name="id" value="<?php echo $value['id']; ?>">
			<div class="form-group">
  				<label class="control-label col-md-3 col-sm-3 col-xs-12">Bedroom Name<span class="required">*</span>
  				</label>
  				<div class="col-md-6 col-sm-6 col-xs-12">
    				<input type="text" name="bedroom_name"  class="form-control col-md-7 col-xs-12" data-parsley-trigger="keyup" data-parsley-maxlength="255" value="<?php echo $value['bedroom_name']; ?>" required="">
  				</div>
			</div>

			<div class="form-group">
  				<label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span>
  				</label>
  				<div class="col-md-6 col-sm-6 col-xs-12">
    				<select name="status" id="status" class="form-control" required="">
                        <option value="">Select Status...</option>
                        <option value="1" <?php if($value['status'] == 1){ echo "selected"; } ?>>Active</option>
                        <option value="0" <?php if($value['status'] == 0){ echo "selected"; } ?>>Inactive</option>
                    </select>
  				</div>
			</div>
			
			<div class="form-group">
  				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
    				<button type="reset" class="btn btn-primary" data-dismiss="modal">Cancel</button>
    				<button type="submit" class="btn btn-success">Update</button>
  				</div>
			</div>
		</form>

		<script type="text/javascript">
	    	$(function () {
			    $('form#edit').parsley().on('field:validated', function() {
			        var ok = $('.parsley-error').length === 0;
			        $('.bs-callout-info').toggleClass('hidden', !ok);
			        $('.bs-callout-warning').toggleClass('hidden', ok);
			    })
			    .on('form:submit', function() {
			        var formData = new FormData($("form#edit")[0]);
			        formData.append('type', 'edit_bedroom');

			        /*$(".hidden1").show(); 
			        $("body").addClass('waitMe_body');
			        $("body").addClass('hideMe');
			        $("#disablingDiv").show();*/

			        $.ajax({
			            type: "POST",
			            dataType: "json",
			            url: "../../controller/masterController.php",
			            data: formData,
			            //async: false,
			            cache: false,
			            contentType: false,
			            processData: false,
			            success: function(user) {
			                if(user["errCode"] == -1){
			                    var msg=user["errMsg"];
			                    bootbox.alert(msg, function() {
			                        location.reload();
			                    });
			                }else{
			                	var msg=user["errMsg"];
			                    bootbox.alert(msg, function() {
			                    });
			                }

			            },
			            error: function() {
			                bootbox.alert("Failed to update details.", function() {});
			            },
			            progress: function(e) {
			                if(e.lengthComputable) {
			                    //calculate the percentage loaded
			                    var pct = (e.loaded / e.total) * 100;

			                    //log percentage loaded
			                    //console.log(pct);
			                    $('#progress1').html(pct.toPrecision(3) + '%');
			                    $('#progress1').attr("aria-valuenow",pct.toPrecision(3) + '%');
			                    $('#progress1').css("width",pct.toPrecision(3) + '%');
			                }
			                //this usually happens when Content-Length isn't set
			                else {
			                    $("body").removeClass('waitMe_body');
			                    $("body").removeClass('hideMe');
			                    //console.warn('Content Length not reported!');
			                }
			            }
			        });
			    });
			});
	    </script>
<?php
	}

	if($_POST['type'] == "edit_bedroom"){
		foreach ($_POST as $key => $value) {
			$post_array[$key] = cleanQueryParameter($connAdmin,cleanXSS($value));
		}

		$query = "UPDATE bedrooms SET bedroom_name = '".$post_array['bedroom_name']."', status = '".$post_array['status']."', updated_at = '".date("Y-m-d H:i:s")."' WHERE id=".$post_array['id'];
				
		$result = runQuery($query, $connAdmin);
		
		if(noError($result)){
			$returnArr = setErrorStack($query, -1, "Details Updated.", $extraArg);
		}else{
			$returnArr = setErrorStack($query, 3, null, $extraArg);
		}

		echo(json_encode($returnArr));
	}

	if($_POST['type'] == "delete_bedroom"){
		$query = "UPDATE bedrooms SET status = 0, updated_at = '".date("Y-m-d H:i:s")."' WHERE id=".$_POST['id'];				
		$result = runQuery($query, $connAdmin);
		
		if(noError($result)){
			$returnArr = setErrorStack($query, -1, "Details Deleted.", $extraArg);
		}else{
			$returnArr = setErrorStack($query, 3, null, $extraArg);
		}

		echo(json_encode($returnArr));
	}

	if($_POST['type'] == "add_specification"){
		$post_array = array();
		foreach($_POST as $key => $value) {    
		    $post_array[$key] = cleanQueryParameter($connAdmin,cleanXSS($value)); 
		}

		$query = "INSERT INTO specification (`name`,
												`status`,
												`created_at`,
												`updated_at`
												) VALUES 
												(
													'".$post_array['name']."',
													'".$post_array['status']."',
													'".date("Y-m-d H:i:s")."',
			                                        '".date("Y-m-d H:i:s")."'
												)";
				
		$result = runQuery($query, $connAdmin);
		
		if(noError($result)){
			$returnArr = setErrorStack($query, -1, "Details Added.");
		}else{
			$returnArr = setErrorStack($query, 3, null, $extraArg);
			printArr($query);
		}

		echo(json_encode($returnArr));
	}

	if($_POST['type'] == "get_specification_data"){
		$id = $_POST['id'];

		$query = "SELECT * FROM specification WHERE id = ".$id;
		$result = runQuery($query, $connAdmin);

		$value = mysqli_fetch_assoc($result["dbResource"]);

?>
		<form id="edit" name="edit" action="javascript:;" class="form-horizontal form-label-left" data-parsley-validate="">
			<input type="hidden" name="id" value="<?php echo $value['id']; ?>">
			<div class="form-group">
  				<label class="control-label col-md-3 col-sm-3 col-xs-12">Name<span class="required">*</span>
  				</label>
  				<div class="col-md-6 col-sm-6 col-xs-12">
    				<input type="text" name="name"  class="form-control col-md-7 col-xs-12" data-parsley-trigger="keyup" data-parsley-maxlength="255" value="<?php echo $value['name']; ?>" required="">
  				</div>
			</div>

			<div class="form-group">
  				<label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span>
  				</label>
  				<div class="col-md-6 col-sm-6 col-xs-12">
    				<select name="status" id="status" class="form-control" required="">
                        <option value="">Select Status...</option>
                        <option value="1" <?php if($value['status'] == 1){ echo "selected"; } ?>>Active</option>
                        <option value="0" <?php if($value['status'] == 0){ echo "selected"; } ?>>Inactive</option>
                    </select>
  				</div>
			</div>
			
			<div class="form-group">
  				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
    				<button type="reset" class="btn btn-primary" data-dismiss="modal">Cancel</button>
    				<button type="submit" class="btn btn-success">Update</button>
  				</div>
			</div>
		</form>

		<script type="text/javascript">
	    	$(function () {
			    $('form#edit').parsley().on('field:validated', function() {
			        var ok = $('.parsley-error').length === 0;
			        $('.bs-callout-info').toggleClass('hidden', !ok);
			        $('.bs-callout-warning').toggleClass('hidden', ok);
			    })
			    .on('form:submit', function() {
			        var formData = new FormData($("form#edit")[0]);
			        formData.append('type', 'edit_specification');

			        /*$(".hidden1").show(); 
			        $("body").addClass('waitMe_body');
			        $("body").addClass('hideMe');
			        $("#disablingDiv").show();*/

			        $.ajax({
			            type: "POST",
			            dataType: "json",
			            url: "../../controller/masterController.php",
			            data: formData,
			            //async: false,
			            cache: false,
			            contentType: false,
			            processData: false,
			            success: function(user) {
			                if(user["errCode"] == -1){
			                    var msg=user["errMsg"];
			                    bootbox.alert(msg, function() {
			                        location.reload();
			                    });
			                }else{
			                	var msg=user["errMsg"];
			                    bootbox.alert(msg, function() {
			                    });
			                }

			            },
			            error: function() {
			                bootbox.alert("Failed to update details.", function() {});
			            },
			            progress: function(e) {
			                if(e.lengthComputable) {
			                    //calculate the percentage loaded
			                    var pct = (e.loaded / e.total) * 100;

			                    //log percentage loaded
			                    //console.log(pct);
			                    $('#progress1').html(pct.toPrecision(3) + '%');
			                    $('#progress1').attr("aria-valuenow",pct.toPrecision(3) + '%');
			                    $('#progress1').css("width",pct.toPrecision(3) + '%');
			                }
			                //this usually happens when Content-Length isn't set
			                else {
			                    $("body").removeClass('waitMe_body');
			                    $("body").removeClass('hideMe');
			                    //console.warn('Content Length not reported!');
			                }
			            }
			        });
			    });
			});
	    </script>
<?php
	}

	if($_POST['type'] == "edit_specification"){
		foreach ($_POST as $key => $value) {
			$post_array[$key] = cleanQueryParameter($connAdmin,cleanXSS($value));
		}

		$query = "UPDATE specification SET name = '".$post_array['name']."', status = '".$post_array['status']."', updated_at = '".date("Y-m-d H:i:s")."' WHERE id=".$post_array['id'];
				
		$result = runQuery($query, $connAdmin);
		
		if(noError($result)){
			$returnArr = setErrorStack($query, -1, "Details Updated.", $extraArg);
		}else{
			$returnArr = setErrorStack($query, 3, null, $extraArg);
		}

		echo(json_encode($returnArr));
	}

	if($_POST['type'] == "delete_specification"){
		$query = "UPDATE specification SET status = 0, updated_at = '".date("Y-m-d H:i:s")."' WHERE id=".$_POST['id'];				
		$result = runQuery($query, $connAdmin);
		
		if(noError($result)){
			$returnArr = setErrorStack($query, -1, "Details Deleted.", $extraArg);
		}else{
			$returnArr = setErrorStack($query, 3, null, $extraArg);
		}

		echo(json_encode($returnArr));
	}
?>