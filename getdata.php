<?php
session_start();
$data = 0;
$username = 0;
$username = $_SESSION['username'];


if(isset($_POST['command'])){
	$command = $_POST['command'];
}else{
	$command = "none";
}

if(isset($_POST['extradata'])){
	$data = $_POST['extradata'];
}else{
	$data = "none";
}

function writeCourses(){
	echo("Feature not yet implemented");
}

function showCourses($data, $username){
	
	if($data == "useOld"){
		$filename = "../_userdata/" . $username . "/courses.txt";
		$endl = ";";
		$endi = ":";
	}else{
		$filename = "../_userdata2/" . $username . "/courses.txt";
		$endl = "/l/";
		$endi = "/i/";
	}

	if(file_exists($filename)){
		$rawdata = file_get_contents($filename);
		
		$rawcourses = explode($endl, $rawdata);
		$coursenames = [];

		foreach($rawcourses as $tmpcourse){
			array_push($coursenames, explode($endi, $tmpcourse)[0]);
		}
		return $coursenames;
	}else{
		return("emptyArray");
	}
}

if($command == "showCourses"){
	echo json_encode(showCourses($data, $username));
}else if($command=="writeCourses"){
	echo json_encode(writeCourses());
}else{
	echo json_encode("Error");
}
?>