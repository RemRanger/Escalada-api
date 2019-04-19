<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
session_start();
include_once 'dbconnect.php';

$IdLocation = mysqli_real_escape_string($conn, $_POST['locationId']);
$Date = mysqli_real_escape_string($conn, $_POST['date']);
$PartnerIds = $_POST['partnerIds'];
$Comment = mysqli_real_escape_string($conn, $_POST['comment']);

$IdUser = $_POST["userId"];

$success = True;
if(!mysqli_query($conn, "INSERT INTO Session (IdLocation, Date) VALUES('$IdLocation', '$Date')"))
{
	$success = False;

}

$IdSession = $conn->insert_id;
if ($success)
{
	echo '{"id":' . $conn->insert_id . '}';

	if(!mysqli_query($conn, "INSERT INTO SessionToUser (IdSession, IdUser, Comment) VALUES('$IdSession', '$IdUser', '$Comment')"))
	{
		$success = False;
	}
}

if ($success && !empty($PartnerIds))
{
	foreach ($PartnerIds as $IdPartner)
	{
		if(!mysqli_query($conn, "INSERT INTO SessionToUser (IdSession, IdUser) VALUES('$IdSession', '$IdPartner')"))
		{
			$success = False;
			break;
		}
	}	
}

