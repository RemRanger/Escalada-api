<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
session_start();
include_once 'dbconnect.php';

$Id = $_GET["id"];

$sql = "SELECT id, name, websiteUrl, latitude, longitude, (SELECT COUNT(*) FROM LocationRouteType WHERE IdLocation = Location.Id AND RouteType != 'Boulder') ropeTypeCount 
		FROM Location";
if (isset($Id))
	$sql .= "
WHERE Id = $Id";

$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
	$outp = $result->fetch_all(MYSQLI_ASSOC);

	echo json_encode($outp, JSON_NUMERIC_CHECK);
}

$conn->close();
?>
