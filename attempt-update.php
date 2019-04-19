<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
session_start();
include_once 'dbconnect.php';

$Id = mysqli_real_escape_string($conn, $_POST['id']);
$UserId = mysqli_real_escape_string($conn, $_POST['userId']);
$SessionId = mysqli_real_escape_string($conn, $_POST['sessionId']);
$RouteId = mysqli_real_escape_string($conn, $_POST['routeId']);
$Comment = mysqli_real_escape_string($conn, $_POST['comment']);
$Result = mysqli_real_escape_string($conn, $_POST['result']);
$Percentage = mysqli_real_escape_string($conn, $_POST['percentage']);

$IdUser = $_POST["userId"];

$success = True;
if(!mysqli_query($conn, "UPDATE Attempt SET IdUser = '$UserId', IdSession = '$SessionId', IdRoute = '$RouteId', Comment = '$Comment', Result = '$Result', Percentage = '$Percentage' WHERE Id = '$Id'"))
{
	$success = False;
}

if ($success)
	echo '{"id":' . $Id . '}';
