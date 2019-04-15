<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
session_start();
include_once 'dbconnect.php';

$UserId = $_GET["userId"];


$sql = "
select Ses.Id id, SesToUsr.Comment comment, Ses.Date date, Loc.Id locationId, Loc.Name locationName, GROUP_CONCAT(DISTINCT Usr.FirstName ORDER BY Usr.FirstName SEPARATOR ', ') mates
from Session Ses
join SessionToUser SesToUsr on SesToUsr.IdSession = Ses.Id
join Location Loc on Loc.Id = Ses.IdLocation
left outer join SessionToUser SesToUsrWith on SesToUsrWith.IdSession = Ses.Id
left outer join User Usr on Usr.Id = SesToUsrWith.IdUser
where SesToUsr.IdUser = $UserId and SesToUsrWith.IdUser <> $UserId
group by Ses.Id, SesToUsr.Comment, Ses.Date, Loc.Name
order by Ses.Date desc
";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    $outp = $result->fetch_all(MYSQLI_ASSOC);

	echo json_encode($outp, JSON_NUMERIC_CHECK);
}

$conn->close();
?>
