<?php
	$sqlInfo = parse_ini_file("sqlServerInformation.ini");
	// $servername = $sqlInfo["servername"];
	// $username = $sqlInfo["username"];
	// $password = $sqlInfo["password"];
	// $dbname = $sqlInfo["dbname"];
	
	$servername = "localhost"; //40.133.254.141
	$username = "18_jaink";
	$password = "DyztWt6Py6V6drmt";
	$dbname = "justice17";
	$dbport = 80;
	
	// NEW CODE TO REPLACE DEPRECIATED CODE
	echo $servername." ".$username." ".$password." ".$dbname."<br>";
	// NONFUNCTIONING CODE
	$con = mysqli_connect($servername, $username, $password, $dbname); 
	/*
	try {
		$con = new PDO('mysql:host=localhost;dbname=justice17', "18_jaink", "DyztWt6Py6V6drmt");
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}
	*/
	
	/*if (!$link) {
	    echo "Error: Unable to connect to MySQL." . PHP_EOL;
	    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}*/
	
	$studentid = $_GET['studentid'];
	$studentemail = $_GET['studentemail'];
	echo $studentid." ".$studentemail;
	
	$stmt = $con->prepare("SELECT * FROM `users` WHERE `id` = ? OR `email` = ?");
	$stmt->bind_param("ss", $studentid, $studentemail);
	$stmt->execute();
	$result = $stmt->get_result();
	//$result = $stmt->fetch();

	/**
	 * DEPRECIATED CODE
	 * VULNERABLE TO SQL INJECTION
	 * 
	 
	$con = mysqli_connect($servername, $username, $password, $dbname);



	if ($studentid == "216397") {
		header("Location: login.php"); 			
		die();
	}
	
	$studentid = mysqli_real_escape_string($con, $studentid);
	$studentemail = mysqli_real_escape_string($con, $studentemail);

  	$sql = "SELECT * FROM `users` WHERE `id` = '$studentid' OR `email` = '$studentemail'";
	$result = mysqli_query($con, $sql);
	
	 * 
	 */
	

	if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        setCookie("justicesummit_studentid", $row["id"], time() + 86400);
        setCookie("justicesummit_studentemail", $row["email"], time() + 86400);
        setCookie("justicesummit_studentfirst", $row["firstname"], time() + 86400);
        setCookie("justicesummit_studentlast", $row["lastname"], time() + 86400);
        setCookie("justicesummit_studentgrade", $row["grade"], time() + 86400);
        header("Location: index.php");
        die();
    } else {
        header("Location: login.php?state=2");  
        die(); 
    }     

	$con->close();
	
?>