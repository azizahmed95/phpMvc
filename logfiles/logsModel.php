<?php
	function getxmlRangeData($fromdate,$dir){
		//echo($fromdate);
		//echo($dir);
	    if ($fromdate) {

	        $datetimen1 = explode("-", $fromdate);
	        $fromdate = explode("/", trim($datetimen1["0"]));

	        $startyear = $fromdate["0"];
	        $startmonth = $fromdate["1"];
	        $startdate = $fromdate["2"];

	        $todate = explode("/", trim($datetimen1["1"]));

	        $endyear = $todate["0"];
	        $endmonth = $todate["1"];
	        $enddate = $todate["2"];

	        $startmonthnew = $startmonth;
	        $xmlstring = array();
	        for ($i = $startyear; $i <= $endyear; $i++) {
	            for ($j = $startmonthnew; $j < 13; $j++) {
	                $number = cal_days_in_month(CAL_GREGORIAN, $j, $i);

	                for ($k = $startdate; $k <= $number; $k++) {


	                    if (strlen($j) == 1) {
	                        $j = "0" . $j;
	                    }

	                    if (strlen($k) == 1) {
	                        $k = "0" . $k;
	                    }
	                    $rootUrlnew =  $dir . $i . "/" . $j . "/" . $k;
	                    //echo($rootUrlnew);
	                    $data = scandir($rootUrlnew);
	                    //echo($data);
	                    foreach ($data as $key => $value) {
	                    	if ($value != "." && $value != "..") {
		                        $segs = loadMYxml($rootUrlnew."/".$value);

		                        foreach ($segs as $value) {
		                            array_push($xmlstring, $value);
		                        }

		                    }
	                    }

	                    if ($k == $number) {
	                        $startdate = 1;
	                        break;
	                    }


	                    if ($endmonth == $j) {
	                        if ($k == $enddate) {
	                            break;
	                        }
	                    }

	                }

	                if ($j == 12) {
	                    $startmonthnew = 1;
	                    break;
	                }


	                if ($endyear == $i) {
	                    if ($j == $endmonth) {
	                        break;
	                    }
	                }


	            }
	        }
	        
	        return $xmlstring;
	    }
	}

	function loadMYxml($file){
	    if (simplexml_load_file($file)) {
	        $use_errors = libxml_use_internal_errors(true);
	        $data = simplexml_load_file($file);

	        if($data->activity){
		        libxml_clear_errors();
		        libxml_use_internal_errors($use_errors);
		        return $data;
	        }else{
	        	$content = htmlentities(file_get_contents($file));
		        $content = htmlentities("<root>").$content.htmlentities("</root>");
		        file_put_contents($file, htmlspecialchars_decode(htmlentities($content, ENT_NOQUOTES, 'UTF-8', false), ENT_NOQUOTES));
		        $data = simplexml_load_file($file);
	        	return $data;
	        }

	        
	    } else {
	        //echo '<span style="color:red;font-weight: bold;font-size: medium">Error in XML File Please Repair File:' . $file . '</span><br/>';
	        $content = htmlentities(file_get_contents($file));
	        $content = htmlentities("<root>").$content.htmlentities("</root>");
	        file_put_contents($file, htmlspecialchars_decode(htmlentities($content, ENT_NOQUOTES, 'UTF-8', false), ENT_NOQUOTES));

	        if (simplexml_load_file($file)) {
	        	$data = simplexml_load_file($file);
	        	return $data;
	        }else{
	        	echo '<span style="color:red;font-weight: bold;font-size: medium">Error in XML File Please Repair File:' . $file . '</span><br/>';
	        }
	    }
	}
?>