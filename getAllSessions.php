<?php

	$sqlInfo = parse_ini_file("sqlServerInformation.ini");
	$servername = $sqlInfo["servername"];
	$username = $sqlInfo["username"];
	$password = $sqlInfo["password"];
	$dbname = $sqlInfo["dbname"];

	$con = mysqli_connect($servername, $username, $password, $dbname);

  	$sql = "SELECT * FROM `sessions`"; // no vulnerability
	$result = mysqli_query($con, $sql); 

    $sessions = array();
    while($row = mysqli_fetch_assoc($result)) {
        $sessions[$row["id"].'-'.$row["block"]] = $row;
    }

    echo json_encode($sessions);

	$con->close();
	
?>