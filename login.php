<?php

session_start();

include("dbinfo.php");

$username = $_POST['username'];
$password = $_POST['password'];

$conn = mysql_connect($DBINFO_HOST, $DBINFO_USERNAME, $DBINFO_PASSWORD);
mysql_select_db($DBINFO_DATABASE, $conn);

$username = mysql_real_escape_string($username);
$query = "SELECT password, salt
        FROM users
        WHERE username = '$username';";
$result = mysql_query($query);
if(mysql_num_rows($result) < 1) //no such user exists
{
	$_SESSION['loginerror'] == 1;

	$message="Error: Username and password combination not found.";

}
$userData = mysql_fetch_array($result, MYSQL_ASSOC);
$hash = hash('sha256', $userData['salt'] . hash('sha256', $password) );
if($hash != $userData['password']) //incorrect password
{
	$message="Error: Username and password combination not found.";

}else if(strlen($username) >= 6){
	session_regenerate_id();
	$_SESSION['valid'] = 1;
	$_SESSION['username'] = $username;	
	
	$message="success";
}else{
	$message="Error: Username too short.";
}

echo json_encode($message);
?>