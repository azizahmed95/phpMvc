<?php

	/*
	The addslashes() function returns a string with backslashes in front of predefined characters.

	The predefined characters are:

	single quote (')
	double quote (")
	backslash (\)
	NULL
	
	*/
	echo "Add Slashes demo<br><br>";

	$str = "Who's Bag is this,";
	$str2 = "This is 'not' safe in a database query";


	$str3 = "This is 'safe' in database query";

	echo $str." ".$str2;

	echo "<br><br>";

	echo addslashes($str)." ".addslashes($str3);

	echo "<br><br>";


	$str = "This is some <b>bold</b> text with htmlspecialchars.";
	echo htmlspecialchars($str);

	$str1 = "This is some <b>bold</b> text without htmlspecialchars.";
	echo "<br>".$str1;

	//mysqli_real escape_string($conn,$string)
	//It accepts connection and string as a parameter

	// escape variables for security
	/*
	$firstname = mysqli_real_escape_string($con, $_POST['firstname']);
	$lastname = mysqli_real_escape_string($con, $_POST['lastname']);
	$age = mysqli_real_escape_string($con, $_POST['age']);

	*/


/*	The htmlspecialchars() function converts some predefined characters to HTML entities.

	The predefined characters are:

	& (ampersand) becomes &amp;
	" (double quote) becomes &quot;
	' (single quote) becomes &#039;
	< (less than) becomes &lt;
	> (greater than) becomes &gt;*/

?>