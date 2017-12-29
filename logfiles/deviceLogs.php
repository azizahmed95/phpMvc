<?php
	$page_title = "Device Logs";
/*
	require_once("header.php");
	require_once("sidebar.php");
	require_once("../model/logsModel.php");*/
?>

	<div class="content-wrapper">
		<div class="page-title">
			<div>
				<h1><i class="fa fa-mobile"></i> <?php echo $page_title; ?></h1>
			</div>
			<div>
				<ul class="breadcrumb">
					<li><i class="fa fa-home fa-lg"></i></li>
              		<li class="active"><a href="#"><?php echo $page_title; ?></a></li>
				</ul>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="card">

					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs" id="myTab">
							<li class="active"><a href="#tab1" data-toggle="tab">Device Registration API</a></li>
	                        <li><a href="#tab2" data-toggle="tab">FCM API</a></li>
	                        <li><a href="#tab3" data-toggle="tab">Uninstall Analytics CRON</a></li>
	                        <li><a href="#tab4" data-toggle="tab">Force Update API</a></li>
						</ul>
					</div>
					<div class="tab-content">
						<div class="tab-pane active" id="tab1">
							<section class="content">
								<div class="row">
									<div class="col-md-12">
										<div class="box">
											<div class="box-header with-border">
												<form class="form-inline" method="post" name="form1" action="javascript:;" style="padding: 25px;padding-left: 0;padding-right: 0px;">
				                                    <div class="row">
				                                        <div class="col-sm-9">
				                                            <div class="form-group">
				                                                <div class="input-group">
				                                                    <div class="input-group-addon">
				                                                        <i class="fa fa-calendar"></i>
				                                                    </div>
				                                                    <input type="text" placeholder="Select Start Date"
				                                                           class="form-control" id="start_date1" name="start_date1" value="<?php echo $_POST["start_date1"]; ?>" autocomplete="off" size="23">
				                                                </div><!-- /.input group -->
				                                            </div><!-- /.form group -->

				                                            <div class="form-group">
				                                                <div class="input-group">
				                                                    <div class="input-group-addon">
				                                                        <i class="fa fa-calendar"></i>
				                                                    </div>
				                                                    <input type="text" placeholder="Select End Date"
				                                                           class="form-control" id="end_date1" name="end_date1" value="<?php echo $_POST["end_date1"]; ?>" autocomplete="off" size="23">
				                                                </div><!-- /.input group -->
				                                            </div><!-- /.form group -->

				                                            <div class="form-group">
				                                                <button type="submit" class="btn btn-primary fa fa-search" onclick="OnFindTab1()"></button>
				                                            </div>
				                                        </div>
				                                    </div>
				                                </form>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<?php
											if($_POST["start_date1"] && $_POST["end_date1"]) {
			                                    $datetime1 = $_POST["start_date1"]." - ".$_POST["end_date1"];
			                                }else
			                                {
			                                    $now = date("Y/m/d");
			                                    $datetime1=$now." - ".$now;
			                                }
			                                $dir = $logDeviceRegistration;
			                                $results = getxmlRangeData($datetime1,$dir);
										?>
										<table class="table table-hover table-bordered" id="sampleTable1">
											<thead>
												<tr>
								                    <th>Sr. No</th>
								                    <th>Activity</th>
								                    <th>Steps</th>
								                    <th>Request</th>
								                    <th>Response</th>
												</tr>
											</thead>
											<tbody>
												<!-- <tr></tr> -->
												<?php
													if(count($results) > 0){
														$row_count2 = 1;
														foreach($results as $result) {
															$color = "";
															if ($result->response->attributes()->errCode == "-1") {
																$color = "green";
															}else{
																$color = "red";
															}
												?>
															<tr style="color:<?php echo $color; ?>">
																<td><?php echo $row_count2++; ?></td>
																<td>
																	<?php 
																		echo "<span style='font-weight:bold'>API:</span> " . urldecode($result->attributes()->user);
		                                                				echo "<br/><span style='font-weight:bold'>Timestamp:</span> " . $result->attributes()->timestamp;
		                                                				if ($result->attributes()->device == "app") {
		                                                    				echo "";
		                                                				} else {
		                                                    				echo "<br/><span style='font-weight:bold'>Browser:</span> " . $result->attributes()->browser;
		                                                				}
		                                                				echo "<br/><span style='font-weight:bold'>User IP:</span> " . $result->attributes()->userIp;
		                                                				echo "<br/><span style='font-weight:bold'>Device:</span> " . $result->attributes()->device;
														 				
		                                              ?>
																</td>
																<td>
																	<?php

																		if($result->step1 != ""){
																			echo $result->step1."</br>";
																		}if($result->step2 != ""){
																			echo $result->step2."</br>";
																		}if($result->step3 != ""){
																			echo $result->step3."</br>";
																		}if($result->step4 != ""){
																			echo $result->step4."</br>";
																		}if($result->step5 != ""){
																			echo $result->step5."</br>";
																		}if($result->insert_query != ""){
																			echo "<br><strong>Device query :</strong></br>".$result->insert_query."</br></br>";
																		}
																		if($result->step6 != ""){
																			echo $result->step6."</br>";
																		}
																		if($result->uninstall_query != ""){
																			echo "<br><strong>Uninstall analytics query :</strong></br>".$result->uninstall_query."</br></br>";
																		}
																		if($result->step7 != ""){
																			echo $result->step7."</br>";
																		}
																	?>
																</td>
																<td>
																	<?php
																		$parameters = $result->parameters->attributes()->mobile;
																		foreach ($result->parameters->attributes() as $key => $value) {
																			echo $key." - ".$value."<br/>";
																		}
																	?>
																</td>
																<td>
																	<?php 
																		echo "<span style='font-weight:bold'>Error Code:</span> " . $result->response->attributes()->errCode;
		                                                				echo "<br/><span style='font-weight:bold'>Error Msg:</span> " . $result->response->attributes()->errMsg;
		                                                			?>
																</td>
															</tr>

												<?php
														}
													}else{
												?>
													<tr class="odd">
														<td valign="top" colspan="5" class="dataTables_empty text-center">No matching records found</td>
													</tr>
												<?php
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</section>
						</div>

						<div class="tab-pane" id="tab2">
							<section class="content">
								<div class="row">
									<div class="col-md-12">
										<div class="box">
											<div class="box-header with-border">
												<form class="form-inline" method="post" name="form2" action="javascript:;" style="padding: 25px;padding-left: 0;padding-right: 0px;">
				                                    <div class="row">
				                                        <div class="col-sm-9">
				                                            <div class="form-group">
				                                                <div class="input-group">
				                                                    <div class="input-group-addon">
				                                                        <i class="fa fa-calendar"></i>
				                                                    </div>
				                                                    <input type="text" placeholder="Select Start Date"
				                                                           class="form-control" id="start_date2" name="start_date2" value="<?php echo $_POST["start_date2"]; ?>" autocomplete="off" size="23">
				                                                </div><!-- /.input group -->
				                                            </div><!-- /.form group -->

				                                            <div class="form-group">
				                                                <div class="input-group">
				                                                    <div class="input-group-addon">
				                                                        <i class="fa fa-calendar"></i>
				                                                    </div>
				                                                    <input type="text" placeholder="Select End Date"
				                                                           class="form-control" id="end_date2" name="end_date2" value="<?php echo $_POST["end_date2"]; ?>" autocomplete="off" size="23">
				                                                </div><!-- /.input group -->
				                                            </div><!-- /.form group -->

				                                            <div class="form-group">
				                                                <button type="submit" class="btn btn-primary fa fa-search" onclick="OnFindTab2()"></button>
				                                            </div>
				                                        </div>
				                                    </div>
				                                </form>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<?php
											if($_POST["start_date2"] && $_POST["end_date2"]) {
			                                    $datetime1 = $_POST["start_date2"]." - ".$_POST["end_date2"];
			                                }else
			                                {
			                                    $now = date("Y/m/d");
			                                    $datetime1=$now." - ".$now;
			                                }
			                                $dir = $logFCM;
			                                $results = getxmlRangeData($datetime1,$dir);
										?>
										<table class="table table-hover table-bordered" id="sampleTable2">
											<thead>
												<tr>
								                    <th>Sr. No</th>
								                    <th>Activity</th>
								                    <th>Steps</th>
								                    <th>Request</th>
								                    <th>Response</th>
												</tr>
											</thead>
											<tbody>
												<!-- <tr></tr> -->
												<?php
													if(count($results) > 0){
														$row_count2 = 1;
														foreach($results as $result) {
															$color = "";
															if ($result->response->attributes()->errCode == "-1") {
																$color = "green";
															}else{
																$color = "red";
															}
												?>
															<tr style="color:<?php echo $color; ?>">
																<td><?php echo $row_count2++; ?></td>
																<td>
																	<?php 
																		echo "<span style='font-weight:bold'>API:</span> " . urldecode($result->attributes()->user);
		                                                				echo "<br/><span style='font-weight:bold'>Timestamp:</span> " . $result->attributes()->timestamp;
		                                                				if ($result->attributes()->device == "app") {
		                                                    				echo "";
		                                                				} else {
		                                                    				echo "<br/><span style='font-weight:bold'>Browser:</span> " . $result->attributes()->browser;
		                                                				}
		                                                				echo "<br/><span style='font-weight:bold'>User IP:</span> " . $result->attributes()->userIp;
		                                                				echo "<br/><span style='font-weight:bold'>Device:</span> " . $result->attributes()->device;
														 				
		                                              ?>
																</td>
																<td style="word-break: break-word;">
																	<?php
																		if($result->step1 != ""){
																			echo $result->step1."</br>";
																		}if($result->step2 != ""){
																			echo $result->step2."</br>";
																		}if($result->step3 != ""){
																			echo $result->step3."</br>";
																		}if($result->step4 != ""){
																			echo $result->step4."</br>";
																		}
																		if($result->update_query != ""){
																			echo "<br><strong>Device update query :</strong></br>".$result->update_query."</br></br>";
																		}
																		if($result->step5 != ""){
																			echo $result->step5."</br>";
																		}
																		if($result->uninstall_query != ""){
																			echo "<br><strong>Uninstall analytics update query :</strong></br>".$result->uninstall_query."</br></br>";
																		}
																		if($result->step6 != ""){
																			echo $result->step6."</br>";
																		}if($result->step7 != ""){
																			echo $result->step7."</br>";
																		}
																	?>
																</td>
																<td style="word-break: break-word;">
																	<?php
																		$parameters = $result->parameters->attributes()->mobile;
																		foreach ($result->parameters->attributes() as $key => $value) {
																			echo $key." - ".$value."<br/>";
																		}
																	?>
																</td>
																<td>
																	<?php 
																		echo "<span style='font-weight:bold'>Error Code:</span> " . $result->response->attributes()->errCode;
		                                                				echo "<br/><span style='font-weight:bold'>Error Msg:</span> " . $result->response->attributes()->errMsg;
		                                                			?>
																</td>
															</tr>

												<?php
														}
													}else{
												?>
													<tr class="odd">
														<td valign="top" colspan="5" class="dataTables_empty text-center">No matching records found</td>
													</tr>
												<?php
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</section>
						</div>

						<div class="tab-pane" id="tab3">
							<section class="content">
								<div class="row">
									<div class="col-md-12">
										<div class="box">
											<div class="box-header with-border">
												<form class="form-inline" method="post" name="form3" action="javascript:;" style="padding: 25px;padding-left: 0;padding-right: 0px;">
				                                    <div class="row">
				                                        <div class="col-sm-9">
				                                            <div class="form-group">
				                                                <div class="input-group">
				                                                    <div class="input-group-addon">
				                                                        <i class="fa fa-calendar"></i>
				                                                    </div>
				                                                    <input type="text" placeholder="Select Start Date"
				                                                           class="form-control" id="start_date3" name="start_date3" value="<?php echo $_POST["start_date3"]; ?>" autocomplete="off" size="23">
				                                                </div><!-- /.input group -->
				                                            </div><!-- /.form group -->

				                                            <div class="form-group">
				                                                <div class="input-group">
				                                                    <div class="input-group-addon">
				                                                        <i class="fa fa-calendar"></i>
				                                                    </div>
				                                                    <input type="text" placeholder="Select End Date"
				                                                           class="form-control" id="end_date3" name="end_date3" value="<?php echo $_POST["end_date3"]; ?>" autocomplete="off" size="23">
				                                                </div><!-- /.input group -->
				                                            </div><!-- /.form group -->

				                                            <div class="form-group">
				                                                <button type="submit" class="btn btn-primary fa fa-search" onclick="OnFindTab3()"></button>
				                                            </div>
				                                        </div>
				                                    </div>
				                                </form>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<?php
											if($_POST["start_date3"] && $_POST["end_date3"]) {
			                                    $datetime1 = $_POST["start_date3"]." - ".$_POST["end_date3"];
			                                }else
			                                {
			                                    $now = date("Y/m/d");
			                                    $datetime1=$now." - ".$now;
			                                }
			                                $dir = $logUninstallAnalytics;
			                                $results = getxmlRangeData($datetime1,$dir);
										?>
										<table class="table table-hover table-bordered" id="sampleTable3">
											<thead>
												<tr>
								                    <th>Sr. No</th>
								                    <th>Activity</th>
								                    <th>Steps</th>
								                    <th>Request</th>
								                    <th>Response</th>
												</tr>
											</thead>
											<tbody>
												<!-- <tr></tr> -->
												<?php
													if(count($results) > 0){
														$row_count2 = 1;
														foreach($results as $result) {
															$color = "";
															if ($result->response->attributes()->errCode == "-1") {
																$color = "green";
															}else{
																$color = "red";
															}
												?>
															<tr style="color:<?php echo $color; ?>">
																<td><?php echo $row_count2++; ?></td>
																<td>
																	<?php 
																		echo "<span style='font-weight:bold'>API:</span> " . urldecode($result->attributes()->user);
		                                                				echo "<br/><span style='font-weight:bold'>Timestamp:</span> " . $result->attributes()->timestamp;
		                                                				if ($result->attributes()->device == "app") {
		                                                    				echo "";
		                                                				} else {
		                                                    				echo "<br/><span style='font-weight:bold'>Browser:</span> " . $result->attributes()->browser;
		                                                				}
		                                                				echo "<br/><span style='font-weight:bold'>User IP:</span> " . $result->attributes()->userIp;
		                                                				echo "<br/><span style='font-weight:bold'>Device:</span> " . $result->attributes()->device;
														 				
		                                              ?>
																</td>
																<td style="word-break: break-word;">
																	<?php
																		if($result->step1 != ""){
																			echo $result->step1."</br>";
																		}if($result->step2 != ""){
																			echo $result->step2."</br>";
																		}
																		if($result->select_query != ""){
																			echo "<br><strong>Select query :</strong></br>".$result->select_query."</br></br>";
																		}
																		if($result->step3 != ""){
																			echo $result->step3."</br>";
																		}if($result->step4 != ""){
																			echo $result->step4."</br>";
																		}
																		if($result->update_query != ""){
																			echo "<br><strong>Device update query :</strong></br>".$result->update_query."</br></br>";
																		}
																		if($result->step5 != ""){
																			echo $result->step5."</br>";
																		}
																		if($result->uninstall_query != ""){
																			echo "<br><strong>Uninstall analytics update query :</strong></br>".$result->uninstall_query."</br></br>";
																		}
																		if($result->step6 != ""){
																			echo $result->step6."</br>";
																		}if($result->step7 != ""){
																			echo $result->step7."</br>";
																		}
																	?>
																</td>
																<td style="word-break: break-word;">
																	<?php
																		$parameters = $result->parameters->attributes()->mobile;
																		foreach ($result->parameters->attributes() as $key => $value) {
																			echo $key." - ".$value."<br/>";
																		}
																	?>
																</td>
																<td>
																	<?php 
																		echo "<span style='font-weight:bold'>Error Code:</span> " . $result->response->attributes()->errCode;
		                                                				echo "<br/><span style='font-weight:bold'>Error Msg:</span> " . $result->response->attributes()->errMsg;
		                                                			?>
																</td>
															</tr>

												<?php
														}
													}else{
												?>
													<tr class="odd">
														<td valign="top" colspan="5" class="dataTables_empty text-center">No matching records found</td>
													</tr>
												<?php
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</section>
						</div>

						<div class="tab-pane" id="tab4">
							<section class="content">
								<div class="row">
									<div class="col-md-12">
										<div class="box">
											<div class="box-header with-border">
												<form class="form-inline" method="post" name="form4" action="javascript:;" style="padding: 25px;padding-left: 0;padding-right: 0px;">
				                                    <div class="row">
				                                        <div class="col-sm-9">
				                                            <div class="form-group">
				                                                <div class="input-group">
				                                                    <div class="input-group-addon">
				                                                        <i class="fa fa-calendar"></i>
				                                                    </div>
				                                                    <input type="text" placeholder="Select Start Date"
				                                                           class="form-control" id="start_date4" name="start_date4" value="<?php echo $_POST["start_date4"]; ?>" autocomplete="off" size="23">
				                                                </div><!-- /.input group -->
				                                            </div><!-- /.form group -->

				                                            <div class="form-group">
				                                                <div class="input-group">
				                                                    <div class="input-group-addon">
				                                                        <i class="fa fa-calendar"></i>
				                                                    </div>
				                                                    <input type="text" placeholder="Select End Date"
				                                                           class="form-control" id="end_date4" name="end_date4" value="<?php echo $_POST["end_date4"]; ?>" autocomplete="off" size="23">
				                                                </div><!-- /.input group -->
				                                            </div><!-- /.form group -->

				                                            <div class="form-group">
				                                                <button type="submit" class="btn btn-primary fa fa-search" onclick="OnFindTab4()"></button>
				                                            </div>
				                                        </div>
				                                    </div>
				                                </form>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<?php
											if($_POST["start_date4"] && $_POST["end_date4"]) {
			                                    $datetime1 = $_POST["start_date4"]." - ".$_POST["end_date4"];
			                                }else
			                                {
			                                    $now = date("Y/m/d");
			                                    $datetime1=$now." - ".$now;
			                                }
			                                $dir = $logStorePathForceUpdate;
			                                $results = getxmlRangeData($datetime1,$dir);
										?>
										<table class="table table-hover table-bordered" id="sampleTable4">
											<thead>
												<tr>
								                    <th>Sr. No</th>
								                    <th>Activity</th>
								                    <th>Steps</th>
								                    <th>Request</th>
								                    <th>Response</th>
												</tr>
											</thead>
											<tbody>
												<!-- <tr></tr> -->
												<?php
													if(count($results) > 0){
														$row_count2 = 1;
														foreach($results as $result) {
															$color = "";
															if ($result->response->attributes()->errCode == "-1") {
																$color = "green";
															}else{
																$color = "red";
															}
												?>
															<tr style="color:<?php echo $color; ?>">
																<td><?php echo $row_count2++; ?></td>
																<td>
																	<?php 
																		echo "<span style='font-weight:bold'>API:</span> " . urldecode($result->attributes()->user);
		                                                				echo "<br/><span style='font-weight:bold'>Timestamp:</span> " . $result->attributes()->timestamp;
		                                                				if ($result->attributes()->device == "app") {
		                                                    				echo "";
		                                                				} else {
		                                                    				echo "<br/><span style='font-weight:bold'>Browser:</span> " . $result->attributes()->browser;
		                                                				}
		                                                				echo "<br/><span style='font-weight:bold'>User IP:</span> " . $result->attributes()->userIp;
		                                                				echo "<br/><span style='font-weight:bold'>Device:</span> " . $result->attributes()->device;
														 				
		                                              ?>
																</td>
																<td style="word-break: break-word;">
																	<?php
																		if($result->step1 != ""){
																			echo $result->step1."</br>";
																		}if($result->step2 != ""){
																			echo $result->step2."</br>";
																		}
																		if($result->select_query != ""){
																			echo "<br><strong>Select query :</strong></br>".$result->select_query."</br></br>";
																		}
																		if($result->step3 != ""){
																			echo $result->step3."</br>";
																		}if($result->step4 != ""){
																			echo $result->step4."</br>";
																		}
																		if($result->update_query != ""){
																			echo "<br><strong>Device update query :</strong></br>".$result->update_query."</br></br>";
																		}
																	?>
																</td>
																<td style="word-break: break-word;">
																	<?php
																		$parameters = $result->parameters->attributes()->mobile;
																		foreach ($result->parameters->attributes() as $key => $value) {
																			echo $key." - ".$value."<br/>";
																		}
																	?>
																</td>
																<td>
																	<?php 
																		echo "<span style='font-weight:bold'>Error Code:</span> " . $result->response->attributes()->errCode;
		                                                				echo "<br/><span style='font-weight:bold'>Error Msg:</span> " . $result->response->attributes()->errMsg;
		                                                				echo "<span style='font-weight:bold'>App Version:</span> " . $result->response->attributes()->appVersion;
		                                                				echo "<br/><span style='font-weight:bold'>Force Update:</span> " . $result->response->attributes()->forceUpdate;
		                                                			?>
																</td>
															</tr>

												<?php
														}
													}else{
												?>
													<tr class="odd">
														<td valign="top" colspan="5" class="dataTables_empty text-center">No matching records found</td>
													</tr>
												<?php
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	<script type="text/javascript" src="<?php echo $rootUrlAdminJs; ?>bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="<?php echo $rootUrlAdminJs; ?>jquery.dataTables.min.js"></script>
	 <script type="text/javascript">
	 	var table1 = $('#sampleTable1').DataTable({
	 		"pagingType": "simple_numbers",
	 	});

	 	var table2 = $('#sampleTable2').DataTable({
	 		"pagingType": "simple_numbers",
	 	});

	 	var table3 = $('#sampleTable3').DataTable({
	 		"pagingType": "simple_numbers",
	 	});

	 	var table4 = $('#sampleTable4').DataTable({
	 		"pagingType": "simple_numbers",
	 	});

	</script>
	<script type="text/javascript">
		$(function () {
		    $('#start_date1').datepicker({
		        format: 'yyyy/mm/dd',
		        todayHighlight: true,
				autoclose: true
		    });
		    $('#end_date1').datepicker({
		        format: 'yyyy/mm/dd',
		        todayHighlight: true,
				autoclose: true
		    });
		
		    $('#start_date2').datepicker({
		        format: 'yyyy/mm/dd',
		        todayHighlight: true,
				autoclose: true
		    });
		    $('#end_date2').datepicker({
		        format: 'yyyy/mm/dd',
		        todayHighlight: true,
				autoclose: true
		    });

		    $('#start_date3').datepicker({
		        format: 'yyyy/mm/dd',
		        todayHighlight: true,
				autoclose: true
		    });
		    $('#end_date3').datepicker({
		        format: 'yyyy/mm/dd',
		        todayHighlight: true,
				autoclose: true
		    });

		    $('#start_date4').datepicker({
		        format: 'yyyy/mm/dd',
		        todayHighlight: true,
				autoclose: true
		    });
		    $('#end_date4').datepicker({
		        format: 'yyyy/mm/dd',
		        todayHighlight: true,
				autoclose: true
		    });

		    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
				localStorage.setItem('activeTab', $(e.target).attr('href'));
			});
			var activeTab = localStorage.getItem('activeTab');
			if(activeTab){
				$('#myTab a[href="' + activeTab + '"]').tab('show');
			}
		});

		function OnFindTab1(){
			document.form1.action = "deviceLogs.php?#tab1";
		    document.form1.submit();             // Submit the page
		    return true;
		}

		function OnFindTab2(){
			document.form2.action = "deviceLogs.php?#tab2";
		    document.form2.submit();             // Submit the page
		    return true;
		}
		
		function OnFindTab3(){
			document.form3.action = "deviceLogs.php?#tab3";
		    document.form3.submit();             // Submit the page
		    return true;
		}

		function OnFindTab4(){
			document.form4.action = "deviceLogs.php?#tab4";
		    document.form4.submit();             // Submit the page
		    return true;
		}
	</script>
	

<?php require_once('footer.php'); ?>