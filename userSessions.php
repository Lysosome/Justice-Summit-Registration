<?php

	$sqlInfo = parse_ini_file("sqlServerInformation.ini");
	$servername = $sqlInfo["servername"];
	$username = $sqlInfo["username"];
	$password = $sqlInfo["password"];
	$dbname = $sqlInfo["dbname"];

	$con = mysqli_connect($servername, $username, $password, $dbname);

	$student = $_GET["studentid"];

	$sql = "SELECT `sessionid`, `sessionblock` FROM `registrations` WHERE `studentid` = ?";
	$stmt = $con->prepare($sql);
    $stmt->bind_param("s", $studentid);
    $stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();

	$sessions = array();

	if ($result) {
		while($row = mysqli_fetch_assoc($result)) {
			$sessionid = $row["sessionid"];
			$sessionblock = $row["sessionblock"];
			$sql2 = "SELECT `title`, `location` FROM `sessions` WHERE `id` = '$sessionid' AND `block` = '$sessionblock'";
			$result2 = mysqli_query($con, $sql2);
			$row2 = mysqli_fetch_array($result2);
			$sessiontitle = $row2[0];
			$sessionlocation = $row2[1];
			$sessions[$sessionblock]["id"] = $sessionid;
			$sessions[$sessionblock]["title"] = $sessiontitle;
			$sessions[$sessionblock]["location"] = $sessionlocation;
		}
	}

	echo json_encode($sessions);

	$con->close();
	
?>