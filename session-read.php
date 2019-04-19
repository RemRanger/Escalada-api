<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
session_start();
include_once 'dbconnect.php';

$Id = $_GET["id"];
$UserId = $_GET["userId"];

$sql = "";
if (isset($UserId))
{
	$sql = "
	select 
		Ses.Id id, SesToUsr.Comment comment, Ses.Date date, Loc.Id locationId, Loc.Name locationName, 
		GROUP_CONCAT(Usr.Id SEPARATOR ',') partnerIdsAsString,
		GROUP_CONCAT(DISTINCT CONCAT(Usr.FirstName, ' ', Usr.LastName) ORDER BY Usr.FirstName SEPARATOR ', ') partnerNames
	from Session Ses
	join SessionToUser SesToUsr on SesToUsr.IdSession = Ses.Id
	join Location Loc on Loc.Id = Ses.IdLocation
	left outer join SessionToUser SesToUsrWith on SesToUsrWith.IdSession = Ses.Id and SesToUsrWith.IdUser <> $UserId
	left outer join User Usr on Usr.Id = SesToUsrWith.IdUser
	where SesToUsr.IdUser = $UserId
	group by Ses.Id, SesToUsr.Comment, Ses.Date, Loc.Name
	order by Ses.Date desc, Ses.Id desc
	";
}
elseif (isset($Id))
{
	$sql = "
	select 
		Ses.Id id, Ses.Date date, Loc.Id locationId, Loc.Name locationName
	from Session Ses
	join Location Loc on Loc.Id = Ses.IdLocation
	where Ses.Id = $Id
	";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    $outp = $result->fetch_all(MYSQLI_ASSOC);

	echo json_encode($outp, JSON_NUMERIC_CHECK);
}

$conn->close();
?>
