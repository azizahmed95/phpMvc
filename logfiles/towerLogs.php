<?php
	$page_title = "Tower Logs";

	//require_once("header.php");
	//require_once("sidebar.php");
	require_once("../model/logsModel.php");
	require_once("../config/config.php");
	require_once("../config/errorMap.php");

?>
<!-- ////////bootstrap start///////////// -->

			<!-- Latest compiled and minified CSS -->
			<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
		
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js">
    </script>	
<!-- 
    <link rel="stylesheet" href="https://code.jquery.com/jquery-1.12.4.js">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"> -->
<!-- ////////bootstrap start///////////// -->
<!-- <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
 -->

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
							<li class="active"><a href="#tab1" data-toggle="tab">Tower API</a></li>
	                       </ul>
					</div>
					<br/>
					<div>

						<div class="container">
							<form class="form-inline" method="post" name="form1" action="javascript:;" style="padding: 25px;padding-left: 0;padding-right: 0px;">
							<div class="tab-pane active" id="tab1">
							<div class='col-md-3'>
						        <div class="form-group">
						            <div class='input-group date' id='datetimepicker6'>
						                <input type='text' class="form-control" id="start_date1" name="start_date1"/>
						                <span class="input-group-addon">
						                    <span class="glyphicon glyphicon-calendar"></span>
						                </span>
						            </div>
						        </div>
						    </div>
						    <div class='col-md-3'>
						        <div class="form-group">
						            <div class='input-group date' id='datetimepicker7'>
						                <input type='text' class="form-control" id="end_date1" name="end_date1"/>
						                <span class="input-group-addon">
						                    <span class="glyphicon glyphicon-calendar"></span>
						                </span>
						            </div>
						        </div>
						    </div>
						    <div class="form-group">
                                <input type="submit" value="Submit" name="submit" class="btn btn-primary" onClick="OnFindTab1();">
                            </div>
                        </div>
                    </form>
						</div>
						<script type="text/javascript">
						    $(function () {
						        $('#datetimepicker6').datetimepicker();
						        $('#datetimepicker7').datetimepicker({
						            useCurrent: true //Important! See issue #1075
						        });
						        $("#datetimepicker6").on("dp.change", function (e) {
						            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
						        });
						        $("#datetimepicker7").on("dp.change", function (e) {
						            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
						        });


						    });

						    function OnFindTab1(){
								//alert("hiee");
								document.form1.action = "towerLogs.php?#tab1";
							    document.form1.submit();             // Submit the page
							    return true;
							}
						</script>

					</div>
								<div class="card-body">
									<div class="table-responsive">
										<?php
											if($_POST["start_date1"] && $_POST["end_date1"]) {
			                                    $datetime1 = date('Y/m/d',strtotime($_POST["start_date1"]))." - ".date('Y/m/d',strtotime($_POST["end_date1"]));
			                                    //echo($datetime1);
			                                }else
			                                {
			                                    $now = date("Y/m/d");
			                                    $datetime1=$now." - ".$now;

			                                }
			                                
			                               
			                                $dir = $logAddTower;
			                                $results = getxmlRangeData($datetime1,$dir);
			                                //echo($dir);
			                                //print_r($results);
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
																		}
																		if($result->step3 != ""){
																			echo $result->step3."</br>";
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
					</div>
				</div>
			</div>
		</div>
		
	</div>
	<!--<script type="text/javascript" src="<?php //echo $rootUrlAdminJs; ?>bootstrap-datepicker.min.js"></script>-->
<!-- 	<script type="text/javascript" src="http://www.hansinfotechlocal.in/omblee_web/admin/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="http://www.hansinfotechlocal.in/omblee_web/admin/js/jquery.dataTables.min.js"></script> -->
	 <script type="text/javascript">
	 	var table1 = $('#sampleTable1').DataTable({
	 		"pagingType": "simple_numbers",
	 	});

	</script>
	<script type="text/javascript">
		$(function () {
		    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
				localStorage.setItem('activeTab', $(e.target).attr('href'));
			});
			var activeTab = localStorage.getItem('activeTab');
			if(activeTab){
				$('#myTab a[href="' + activeTab + '"]').tab('show');
			}
		});

	</script>
	

