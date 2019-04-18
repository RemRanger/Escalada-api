<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
session_start();
include_once 'dbconnect.php';

$userName = mysqli_real_escape_string($conn, $_POST['userName']);
$firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
$lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = md5(mysqli_real_escape_string($conn, $_POST['password']));

$result = $conn->query("select count(*) existingCount from User where Username='$userName'");
$row = $result->fetch_assoc();
$existingCount = $row["existingCount"];
if ($existingCount == 0) 
{ 
	if(mysqli_query($conn, "INSERT INTO User(Username, FirstName, LastName, Gender, Email, Password) VALUES('$userName', '$firstName', '$lastName', '$gender', '$email', '$password')"))
	{
		$sql = "SELECT LAST_INSERT_ID() id";

		$result = $conn->query($sql);

		if ($result->num_rows > 0) 
		{
			$row = $result->fetch_assoc();

			echo json_encode($row, JSON_NUMERIC_CHECK);
		} 
	}
}
else
	echo '{"id":-1}';
