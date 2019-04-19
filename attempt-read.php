<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
session_start();
include_once 'dbconnect.php';

$Id = $_GET["id"];
$IdSession = $_GET["sessionId"];
$IdUser = $_GET["userId"];

$sql = "
select Att.Id id, Att.Result result, Att.Percentage percentage, Att.Comment comment, 
Rou.Id routeId, Rou.Color routeColor, Rou.Name routeName, Rou.Type routeType, Rou.Rating routeRating, Rou.Sublocation routeSublocation, Rou.DateUntil routeDateUntil, Rou.PictureFileName routePictureFileName,
Loc.Id locationId, Loc.Name locationName,
Ses.Id sessionId, Ses.Date sessionDate,
Usr.Id userId, Usr.FirstName userFirstName, Usr.LastName userLastName
from Attempt Att
join Route Rou on Rou.Id = Att.IdRoute
join Session Ses on Ses.Id = Att.IdSession
join Location Loc on Loc.Id = Ses.IdLocation 
join User Usr on Usr.Id = Att.IdUser";
if (isset($Id))
	$sql .= " where Att.Id = $Id";
else
{
	if (isset($IdSession) && isset($IdUser))
		$sql .= " where Att.IdSession = $IdSession and Att.IdUser = $IdUser";
	else if (isset($IdSession))
		$sql .= " where Att.IdSession = $IdSession";
	else if (isset($IdUser))
		$sql .= " where Att.IdUser = $IdUser";
}

$sql .= " order by Ses.Date desc, Ses.Id desc, Usr.Id, Att.Order, Att.Id";

$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
	$outp = $result->fetch_all(MYSQLI_ASSOC);

	echo json_encode($outp, JSON_NUMERIC_CHECK);
} 

$conn->close();
?>
