<?php

session_start();

$username = $_POST['username'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];

function createSalt(){
	
	$string = md5(uniqid(rand(), true));
	return substr($string, 0, 3);
	
}

function isXinY($x, $y){
	for($z = 0; $y[$z] != "."; $z++){
		if($y[$z] == $x){
			return true;
		}
	}
	return false;
}


function isValiduName($uname){
	$validchars = explode(" ", "a b c d e f g h i j k l m n o p q r s t u v w x y z A B C D E F G H I J K L M N O P Q R S T U V W X Y Z 1 2 3 4 5 6 7 8 9 0 _ .");
	for($x=0; $x < strlen($uname); $x++){
		if(!isXinY($uname[$x], $validchars)){
			return 0;
		}
	}
	return 1;
}

function registerAcct($username, $pass1, $pass2){

if($pass1 != $pass2)
	return "Error: Passwords do not match.";
if(strlen($username) > 25)
	return "Error: Usernames can not exceed 25 characters.";
if(strlen($username) < 5)
	return "Error: Usernames must be at least 5 characters.";

if(strlen($pass1) < 6)
	return "Error: Passwords must be at least 6 characters.";
	
if(!isValiduName($username))
	return "Error: Username can only contain alphanumeric characters, periods, and underscores.";
	
$hash = hash('sha256', $pass1);



$salt = createSalt();
$hash = hash('sha256', $salt . $hash);

include("dbinfo.php");

$conn = mysql_connect($DBINFO_HOST, $DBINFO_USERNAME, $DBINFO_PASSWORD);
mysql_select_db($DBINFO_DATABASE, $conn);

$username = mysql_real_escape_string($username);
$query = "SELECT password, salt
        FROM users
        WHERE username = '$username';";
$result = mysql_query($query);
if(mysql_num_rows($result) >= 1) //no such user exists
{
	mysql_close();
	return "Error: Username already taken.";
}

$getdatedata = getdate();
$year = $getdatedata["year"];
$month = $getdatedata["mon"];
$day = $getdatedata["mday"];

$date = $month . "/" . $day . "/" . $year;
$query = "INSERT INTO users ( username, password, salt, JoinDate)
		VALUES ( '$username' , '$hash' , '$salt' , '$date');";
		
mysql_query($query);
mysql_close();
//echo '<META HTTP-EQUIV="Refresh" Content="0; URL=login.php">';


return 1;
}
$status = registerAcct($username, $pass1, $pass2);
if($status == 1){
	$message = "success";
}else{
	$message = $status;
}

session_regenerate_id();
$_SESSION['valid'] = 1;
$_SESSION['username'] = $username;

	
echo json_encode($message);
?>