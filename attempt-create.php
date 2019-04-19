<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
session_start();
include_once 'dbconnect.php';

$UserId = mysqli_real_escape_string($conn, $_POST['userId']);
$SessionId = mysqli_real_escape_string($conn, $_POST['sessionId']);
$RouteId = mysqli_real_escape_string($conn, $_POST['routeId']);
$Comment = mysqli_real_escape_string($conn, $_POST['comment']);
$Result = mysqli_real_escape_string($conn, $_POST['result']);
$Percentage = mysqli_real_escape_string($conn, $_POST['percentage']);

$IdUser = $_POST["userId"];

$success = True;
if(!mysqli_query($conn, "INSERT INTO Attempt (IdUser, IdSession, IdRoute, Comment, Result, Percentage) VALUES('$UserId', '$SessionId', '$RouteId', '$Comment', '$Result', '$Percentage')"))
{
	$success = False;
}

$IdSession = $conn->insert_id;
if ($success)
{
	echo '{"id":' . $conn->insert_id . '}';
}
