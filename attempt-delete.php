<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
session_start();
include_once 'dbconnect.php';


$Id = mysqli_real_escape_string($conn, $_POST['id']);

$success = True;
if(!mysqli_query($conn, "DELETE FROM Attempt WHERE Id = '$Id'"))
	$success = False;

if ($success)
	echo '{"id":' . $Id . '}';
