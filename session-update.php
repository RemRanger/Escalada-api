<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
session_start();
include_once 'dbconnect.php';


$Id = mysqli_real_escape_string($conn, $_POST['id']);
$IdLocation = mysqli_real_escape_string($conn, $_POST['locationId']);
$Date = mysqli_real_escape_string($conn, $_POST['date']);
$PartnerIds = $_POST['partnerIds'];
$Comment = mysqli_real_escape_string($conn, $_POST['comment']);
$IdUser = $_POST["userId"];

$success = True;
if(!mysqli_query($conn, "UPDATE Session SET IdLocation = '$IdLocation', Date = '$Date' WHERE Id = '$Id'"))
{
	$success = False;
}

if ($success)
{
	if(!mysqli_query($conn, "UPDATE SessionToUser SET Comment = '$Comment' WHERE IdSession = '$Id' AND IdUser = '$IdUser'"))
	{
		$success = False;
	}
}

if ($success)
{
	if (!mysqli_query($conn, "DELETE FROM SessionToUser WHERE IdSession = '$Id' AND IdUser <> '$IdUser'"))
	{
		$success = False;
	}
}

if ($success && !empty($PartnerIds))
{

	foreach ($PartnerIds as $IdPartner)
	{
		if($IdPartner != $IdUser && !mysqli_query($conn, "INSERT INTO SessionToUser (IdSession, IdUser) VALUES('$Id', '$IdPartner')"))
		{
			$success = False;
			break;
		}
	}	
}

if ($success)
	echo '{"id":' . $Id . '}';
