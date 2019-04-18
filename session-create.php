<?php
session_start();
include_once 'dbconnect.php';

$IdUser = $_SESSION["IdUser"];

$IdLocation = mysqli_real_escape_string($conn, $_POST['locationId']);
$Date = mysqli_real_escape_string($conn, $_POST['date']);
$PartnerIds = $_POST['PartnerIds'];
$Comment = mysqli_real_escape_string($conn, $_POST['comment']);

$success = True;
if(!mysqli_query($conn, "INSERT INTO Session (IdLocation, Date) VALUES('$IdLocation', '$Date')"))
{
	$success = False;

}

$IdSession = $conn->insert_id;
if ($success)
{
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
