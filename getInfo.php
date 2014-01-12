<?php
session_start();
$data = 0;
$username = 0;if(isset($_SESSION['username'])){
	$username = $_SESSION['username'];
}else{	$username="";}

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

/*Calendar Algorithms*/

function isLeapYear($year){
	if($year%400 == 0){
		return true;
	}else if($year%100==0){
		return false;
	}else if($year%4==0){
		return true;
	}else{
		return false;
	}
}

function DaysInMonth($m, $y){
	if($m == 2){
		if(isLeapYear($y)){
			return 29;
		}else{
			return 28;
		}
		
	}else if ($m == 11 || $m == 4 || $m == 6 || $m == 9){
		return 30;
	}else{
		return 31;
	}
}


function dayOfYear($y, $m, $d){
	$c=0;
	for($x=1; $x<$m; $x++){
		$c += DaysInMonth($x, $y);
	}
	$c += $d;
	
	return $c;
}
function dayOfWeekOld($y, $m, $d){
	$w = 1;
	$y = ($y-1)%400 + 1;
	$leap = ($y-1)/4;
	$leap = $leap - ($y-1)/100;
	$leap = $leap + ($y-1)/400;
	
	$reg = $y - 1 - $leap;
	
	$w = $w + $reg;
	$w = $w + 2*$leap;
	
	$w = $w + dayOfYear($y, $m, $d);
	$w = ($w-1)%7 + 1;
	return $w;
}
function dayOfWeek($y, $m, $d){
	$w = 1;	
	$y = ($y-1)%400 + 1;
	$leap = ($y-1)/4;
	$leap = $leap - ($y-1)/100;
	$leap = $leap + ($y-1)/400;
	
	$reg = $y - 1 - $leap;
	
	$w = $w + $reg;
	$w = $w + 2*$leap;
	
	$w = $w + dayOfYear($y, $m, $d);
	$w = ($w)%7 + 1;
	return $w;
}

function gaussWeek($y, $m, $d){
	//Uses Gauss's algorithm to find Jan 1 of the year, then calculates days since then to find day of week.
	$jan = (1+ 5*(($y -1) % 4) + 4*(($y-1) % 100) +6*(($y-1) % 400)) % 7;
	return ($jan + dayOfYear($y, $m, $d-1)) % 7;
}
/*Utilities*/

function increment($username){
	$newfile=false;
	$incrementfilename = "../_userdata2/" . $username . "/incrementor.txt";

	if(file_exists($incrementfilename)){
		$incrementdata = file_get_contents($incrementfilename);
	}else{
		$dir = "../_userdata2/" . $username . "/";
		if(!is_dir($dir)){
	        mkdir($dir);         
	    } 
		$incrementdata = 1;
		$FileHandle = fopen($incrementfilename, 'w') or die("can't open file");
		fclose($FileHandle);
		$newfile=true;
	}


	if($newfile){
		file_put_contents($incrementfilename, $incrementdata);
	}

	$incrementvalue = (int)$incrementdata + 1;
	file_put_contents($incrementfilename, $incrementvalue);
	return $incrementvalue;
}

function writeCourses($newdata, $username){
	$filename = "../_userdata2/" . $username . "/courses.txt";
	$endl = "/l/";
	$endi = "/i/";


	if(file_exists($filename)){
		$data = file_get_contents($filename);
	}else{
		$data = "";
		$dir = "../_userdata2/" . $username . "/";
		if(!is_dir($dir)){
	        mkdir($dir);         
	    } 
		$FileHandle = fopen($filename, 'w') or die("can't open file");
		fclose($FileHandle);
	}
	file_put_contents($filename, $newdata . increment($username) . "/l/" . $data);

	return("success");

}

function deleteCourses($id, $username){
	$filename = "../_userdata2/" . $username . "/courses.txt";
	$endl = "/l/";
	$endi = "/i/";


	if(file_exists($filename)){
		$data = file_get_contents($filename);
	}else{
		$data = "";
		$dir = "../_userdata2/" . $username . "/";
		if(!is_dir($dir)){
	        mkdir($dir);         
	    } 
		$FileHandle = fopen($filename, 'w') or die("can't open file");
		fclose($FileHandle);
	}
	
	$tmpdata = explode("/l/", $data);
	$senddata = "*";
	for($x = 0; $x < count($tmpdata); $x++){
		$tmp = explode("/i/", $tmpdata[$x]);
		if($tmp[7] != $id){
			if($senddata == "*"){
				$senddata = $tmp[0] . $endi . $tmp[1] . $endi . $tmp[2] . $endi . $tmp[3] . $endi . $tmp[4] . $endi . $tmp[5] . $endi . $tmp[6] . $endi . $tmp[7];
			}else{
				$senddata = $senddata ."/l/" . $tmp[0] . $endi . $tmp[1] . $endi . $tmp[2] . $endi . $tmp[3] . $endi . $tmp[4] . $endi . $tmp[5] . $endi . $tmp[6] . $endi . $tmp[7];
			}
		}
	}
	
	file_put_contents($filename, $senddata);
	
	return("success");

}
function deleteWork($id, $username){
	$filename = "../_userdata2/" . $username . "/assignments.txt";
	$endl = "/l/";
	$endi = "/i/";


	if(file_exists($filename)){
		$data = file_get_contents($filename);
	}else{
		$data = "";
		$dir = "../_userdata2/" . $username . "/";
		if(!is_dir($dir)){
	        mkdir($dir);         
	    } 
		$FileHandle = fopen($filename, 'w') or die("can't open file");
		fclose($FileHandle);
	}
	
	$tmpdata = explode("/l/", $data);
	$senddata = "*";
	$hasChanged = false;
	for($x = 0; $x < count($tmpdata); $x++){
		$tmp = explode("/i/", $tmpdata[$x]);
		if(intval($tmp[5]) != $id){
			if($senddata == "*"){
				$hasChanged = true;
				$senddata = $tmp[0] . $endi . $tmp[1] . $endi . $tmp[2] . $endi . $tmp[3] . $endi . $tmp[4] . $endi . $tmp[5] . $endi . $tmp[6];
			}else{
				$hasChanged = true;
				$senddata = $senddata ."/l/" . $tmp[0] . $endi . $tmp[1] . $endi . $tmp[2] . $endi . $tmp[3] . $endi . $tmp[4] . $endi . $tmp[5] . $endi . $tmp[6];
			}
		}
	}
	if(!$hasChanged){
		$senddata == "";
	}
	file_put_contents($filename, $senddata);
	
	return("success");

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
	$coursenames = array();
	if(file_exists($filename)){
		$rawdata = file_get_contents($filename);
		
		$rawcourses = explode($endl, $rawdata);
		

		foreach($rawcourses as $tmpcourse){
			$tmp = explode($endi, $tmpcourse);
			array_push($coursenames, $tmp[0]);
		}
	}
	return $coursenames;
}


function listCourses($username){

	$filename = "../_userdata2/" . $username . "/courses.txt";
	
	$coursenames = array();
	$returnthis = "";

	$endl = "/l/";
	$endi = "/i/";

	if(file_exists($filename)){
		$rawdata = file_get_contents($filename);
		
		$rawcourses = explode($endl, $rawdata);
		

		foreach($rawcourses as $tmpcourse){
			$tmp = explode($endi, $tmpcourse);
			if(isset($tmp[6])){
				array_push($coursenames, $tmp[0] . "/i/" . $tmp[6] . "/i/" . $tmp[7]);
			}
		}
	}
	return $coursenames;
}

function echoAssignments($y, $m, $d, $username){
	$filename = "../_userdata2/" . $username . "/assignments.txt";
	$endl = "/l/";
	$endi = "/i/";

	$date = $m . "/" . $d . "/" . $y;
	if(file_exists($filename)){
		$data = file_get_contents($filename);
	}else{
		$data = "";
		$dir = "../_userdata2/" . $username . "/";
		if(!is_dir($dir)){
	        mkdir($dir);         
	    } 
		$FileHandle = fopen($filename, 'w') or die("can't open file");
		fclose($FileHandle);
	}
	
	$tmpdata = explode("/l/", $data);
	$senddata = "";
	$hasChanged = false;
	for($x = 0; $x < count($tmpdata); $x++){
		$tmp = explode("/i/", $tmpdata[$x]);
		if($tmp[3] == $date){
			$senddata = $senddata . "<div id='courseB" . courseColor($username, $tmp[1]) . "' style='font-size:16px;'>" . $tmp[0] . "</div>";
		}
	}
	return($senddata);
}

function echoAssignment($data1, $username){
	$filename = "../_userdata2/" . $username . "/assignments.txt";
	$endl = "/l/";
	$endi = "/i/";
	
	$tmp1 = explode("/i/", $data1);
	$date = $tmp1[0];
	$id = $tmp1[1];
	
	$data = "";
	if(file_exists($filename)){
		$data = file_get_contents($filename);
	}else{
		$data = "";
		$dir = "../_userdata2/" . $username . "/";
		if(!is_dir($dir)){
	        mkdir($dir);         
	    } 
		$FileHandle = fopen($filename, 'w') or die("can't open file");
		fclose($FileHandle);
	}
	
	$tmpdata = explode("/l/", $data);
	$senddata = "";
	$hasChanged = false;
	for($x = 0; $x < count($tmpdata); $x++){
		$tmp = explode("/i/", $tmpdata[$x]);
		if($tmp[3] == $date && $tmp[1] == $id){
			$senddata = $senddata . "<p style='font-size:24px;margin-top:0px;'>" . $tmp[0] . "</p>";
		}
	}
	return($senddata);
}

function showPinnedCourses($username, $data){
	$filename = "../_userdata2/" . $username . "/courses.txt";
	
	$coursenames = array();
	$endl = "/l/";
	$endi = "/i/";

	if(file_exists($filename)){
		$rawdata = file_get_contents($filename);
		
		$rawcourses = explode($endl, $rawdata);
		

		foreach($rawcourses as $tmpcourse){
		
			$tmp = explode($endi, $tmpcourse);
			if(isset($tmp[6]) && $tmp[6]==$data){
				array_push($coursenames, $tmp[0] . "/i/" . $tmp[7]);
			}
		}
		$sorted = false;
		while($sorted == false){
			$sorted = true;
			for($x = 0; $x<sizeof($coursenames)+1;$x++){
				if(isset($coursenames[$x]) && isset($coursenames[$x+1])){
					$first = $coursenames[$x];
					$second = $coursenames[$x+1];
					$tmp = explode("/i/", $first);
					$tmp2 = explode("/i/", $second);
					if($tmp[1] > $tmp2[1]){
						$coursenames[$x] = $second;
						$coursenames[$x+1] = $first;
						$sorted = false;
					}
				}
			}			
		}
		$returnthis = "";
		$x = 1;
		foreach($coursenames as $tmpcourse){
			$tmp = explode("/i/", $tmpcourse);
			$returnthis = $returnthis . "<div class='course" . $x . "In' style='margin-top:5px;float:left;width:50%';>";
			$returnthis = $returnthis . "<div id='courseH" . $x . "' style='height:24px;width:90%;margin-left:auto;margin-right:auto;padding-bottom:3px;'onclick='handleCourseClick(" . $tmp[1] . ");'>";
			$returnthis = $returnthis . "<p style='display:table;margin-left:auto;margin-right:auto;font-size:20px;'>" . $tmp[0] . "</p>";
			$returnthis = $returnthis . "</div>";
			$returnthis = $returnthis . "</div>";
			
			$x++;
		}
		$returnthis = $returnthis . "<div style='height:250px;width:100%'></div>";
	}
	if(sizeof($coursenames) < 1){
		return " ";
	}
	return $returnthis;
}

function displayCal($date, $username){
	$exploded = explode(":", $date);
	$m=$exploded[0];
	$y=$exploded[1];
	$returnstring = '
	<div class="DoW" id="sun"><div class="dowFloat">Sunday</div></div>
	<div class="DoW"><div class="dowFloat">Monday</div></div>
	<div class="DoW"><div class="dowFloat">Tuesday</div></div>
	<div class="DoW"><div class="dowFloat">Wednesday</div></div>
	<div class="DoW"><div class="dowFloat">Thursday</div></div>
	<div class="DoW"><div class="dowFloat">Friday</div></div>
	<div class="DoW" id="sat"><div class="dowFloat">Saturday</div></div>';
	
	$place = 0;
	
	$firstday = gaussWeek($y, $m, 1);
	if($firstday != 1){
	
		$lenPrev = DaysInMonth($m-1, $y);
		
		for($x = $lenPrev - $firstday; $x < $lenPrev; $x++){
			$date = $x+1;
			$returnstring=$returnstring . '<div class="dayMinor"><div class="dayMarker">'  . $date . '</div>' . echoAssignments($y, $m-1, $date, $username) . '</div>';
			$place += 1;
		}

	}

	$ofMonth = 1;
	while($ofMonth <= DaysInMonth($m, $y)){
		$returnstring=$returnstring . '<div class="dayMajor"><div class="dayMarker">' . $ofMonth . '</div>';
		$returnstring=$returnstring . echoAssignments($y, $m, $ofMonth, $username);
		$returnstring=$returnstring . '</div>';
		$place++;
		if($place>=7){
			$place=0;
		}
		$ofMonth++;
	}

	$date = 1;
	for($x=1;$place<7&&$place>1;$x++){
		$returnstring=$returnstring . '
		<div class="dayMinor"><div class="dayMarker">' . $x . '</div>';
		$returnstring=$returnstring . echoAssignments($y, $m+1, $date, $username);
		$returnstring=$returnstring . '</div>';
		$date++;
		$place++;
	}
	
	for($x=0;$x<7;$x++){
		$returnstring=$returnstring . '
		<div class="dayMinor"><div class="dayMarker">' . $date . '</div>';
		$returnstring=$returnstring . echoAssignments($y, $m+1, $date, $username);
		$returnstring=$returnstring . '</div>';
		$date++;
		$place++;
	}
	
	return $returnstring;
}

function courseOptions($name){

	$filename = "../_userdata2/" . $name . "/courses.txt";
	
	$endl = "/l/";
	$endi = "/i/";

	if(file_exists($filename)){
		$rawdata = file_get_contents($filename);
		
		$rawcourses = explode($endl, $rawdata);
		
		$returnthis = "";
		foreach($rawcourses as $tmpcourse){
			$tmp = explode("/i/", $tmpcourse);
			$returnthis = $returnthis . "<option value = ";
			$returnthis = $returnthis . $tmp[7];
			$returnthis = $returnthis . ">";
			$returnthis = $returnthis . $tmp[0];
			$returnthis = $returnthis . "</option>";
		}
	}
	return $returnthis;
}

function courseColor($username, $data){
	$filename = "../_userdata2/" . $username . "/courses.txt";
	$coursenames = array();
	$endl = "/l/";
	$endi = "/i/";

	if(file_exists($filename)){
		$rawdata = file_get_contents($filename);
		$rawcourses = explode($endl, $rawdata);
		$sorted = false;
		while($sorted == false){
			$sorted = true;
			for($x = 0; $x<sizeof($rawcourses)+1;$x++){
				if(isset($rawcourses[$x]) && isset($rawcourses[$x+1])){
					$first = $rawcourses[$x];
					$second = $rawcourses[$x+1];
					$tmp = explode("/i/", $first);
					$tmp2 = explode("/i/", $second);
					if($tmp[7] > $tmp2[7]){
						$rawcourses[$x] = $second;
						$rawcourses[$x+1] = $first;
						$sorted = false;
					}
				}
			}			
		}
		$returnthis = "";
		$x = 1;
		foreach($rawcourses as $tmpcourse){
			$tmp = explode("/i/", $tmpcourse);
			if($tmp[7] == $data){
				return $x;
			}
			
			$x++;
		}
		return "lololol";
	}
}
function courseName($username, $data){
	$filename = "../_userdata2/" . $username . "/courses.txt";
	$coursenames = array();
	$endl = "/l/";
	$endi = "/i/";

	if(file_exists($filename)){
		$rawdata = file_get_contents($filename);
		$rawcourses = explode($endl, $rawdata);
		$sorted = false;
		while($sorted == false){
			$sorted = true;
			for($x = 0; $x<sizeof($rawcourses)+1;$x++){
				if(isset($rawcourses[$x]) && isset($rawcourses[$x+1])){
					$first = $rawcourses[$x];
					$second = $rawcourses[$x+1];
					$tmp = explode("/i/", $first);
					$tmp2 = explode("/i/", $second);
					if($tmp[7] > $tmp2[7]){
						$rawcourses[$x] = $second;
						$rawcourses[$x+1] = $first;
						$sorted = false;
					}
				}
			}			
		}
		$returnthis = "";
		$x = 1;
		foreach($rawcourses as $tmpcourse){
			$tmp = explode("/i/", $tmpcourse);
			if($tmp[7] == $data){
				return $tmp[0];
			}
			
			$x++;
		}
		return "lololol";
	}
}
function writeWork($newdata, $username){
	$filename = "../_userdata2/" . $username . "/assignments.txt";
	$endl = "/l/";
	$endi = "/i/";


	if(file_exists($filename)){
		$data = file_get_contents($filename);
	}else{
		$data = "";
		$dir = "../_userdata2/" . $username . "/";
		if(!is_dir($dir)){
	        mkdir($dir);         
	    } 
		$FileHandle = fopen($filename, 'w') or die("can't open file");
		fclose($FileHandle);
	}
	file_put_contents($filename, $newdata . increment($username) . "/i/0/l/" . $data);

	return("success");
}

function sortDate($mdy){
	$y = explode("/", $mdy)[2];
	$m = explode("/", $mdy)[0];
	$d = explode("/", $mdy)[1];
	if(intval($m) < 10){
		$m = "0" . $m;
	}
	if(intval($d) < 10){
		$d = "0" . $d;
	}
	return intval($y . $m . $d);
}

function boolOpposite($val){
	if($val == 0 || $val == "0"){
		return 1;
	}else{
		return 0;
	}
}

function toggleComplete($username, $id){

	$filename = "../_userdata2/" . $username . "/assignments.txt";
	$endl = "/l/";
	$endi = "/i/";


	if(file_exists($filename)){
		$data = file_get_contents($filename);
	}else{
		$data = "";
		$dir = "../_userdata2/" . $username . "/";
		if(!is_dir($dir)){
	        mkdir($dir);         
	    } 
		$FileHandle = fopen($filename, 'w') or die("can't open file");
		fclose($FileHandle);
	}
	
	$tmpdata = explode("/l/", $data);
	$senddata = "*";
	$hasChanged = false;
	for($x = 0; $x < count($tmpdata); $x++){
		$tmp = explode("/i/", $tmpdata[$x]);
		if(intval($tmp[5]) != $id){
			if($senddata == "*"){
				$hasChanged = true;
				$senddata = $tmp[0] . $endi . $tmp[1] . $endi . $tmp[2] . $endi . $tmp[3] . $endi . $tmp[4] . $endi . $tmp[5] . $endi . $tmp[6];
			}else{
				$hasChanged = true;
				$senddata = $senddata ."/l/" . $tmp[0] . $endi . $tmp[1] . $endi . $tmp[2] . $endi . $tmp[3] . $endi . $tmp[4] . $endi . $tmp[5] . $endi . $tmp[6];
			}
		}else{
			if($senddata == "*"){
				$hasChanged = true;
				$senddata = $tmp[0] . $endi . $tmp[1] . $endi . $tmp[2] . $endi . $tmp[3] . $endi . $tmp[4] . $endi . $tmp[5] . $endi . boolOpposite($tmp[6]);
			}else{
				$hasChanged = true;
				$senddata = $senddata ."/l/" . $tmp[0] . $endi . $tmp[1] . $endi . $tmp[2] . $endi . $tmp[3] . $endi . $tmp[4] . $endi . $tmp[5] . $endi . boolOpposite($tmp[6]);
			}
		}
	}
	if(!$hasChanged){
		$senddata == "";
	}
	file_put_contents($filename, $senddata);
	
	return("success");

}

function showAllAssignments($username){
	$filename = "../_userdata2/" . $username . "/assignments.txt";
	
	$coursenames = array();
	$endl = "/l/";
	$endi = "/i/";

	if(file_exists($filename)){
		$rawdata = file_get_contents($filename);
		
		$rawcourses = explode($endl, $rawdata);
		
		$coursenames = $rawcourses;
		
		$sorted = false;
		while($sorted == false){
			$sorted = true;
			/*
			for($x = 0; $x<sizeof($coursenames);$x++){
				if(isset($coursenames[$x]) && isset($coursenames[$x+1])){
					$first = $coursenames[$x];
					$second = $coursenames[$x+1];
					$tmp = explode("/i/", $first);
					$tmp2 = explode("/i/", $second);
					if(($tmp[6] == 1 || $tmp[6] == "1") && ($tmp2[6] == 0 || $tmp2[6] == "0")){
						$coursenames[$x] = $second;
						$coursenames[$x+1] = $first;
						$sorted = false;
					}
				}
			}
			*/
			
			for($x = 0; $x<sizeof($coursenames);$x++){
				if(isset($coursenames[$x]) && isset($coursenames[$x+1])){
					$first = $coursenames[$x];
					$second = $coursenames[$x+1];
					$tmp = explode("/i/", $first);
					$tmp2 = explode("/i/", $second);
					if(sortDate($tmp[3]) > sortDate($tmp2[3]) && $tmp[6] == "0"){
						$coursenames[$x] = $second;
						$coursenames[$x+1] = $first;
						$sorted = false;
					}
				}
			}	
			
		}
		
		$returnthis = "";
		$x = 1;
		foreach($coursenames as $tmpcourse){
			$tmp = explode("/i/", $tmpcourse);
			$id = courseColor($username, $tmp[1]);
			if(isset($tmp[5])){
				$returnthis = $returnthis . "<div id='courseB" . $id . "' style='height:24px;width:90%;margin-left:auto;margin-right:auto;padding-bottom:3px'onclick='handleWorkClick(" . $tmp[5] . ")'>";
				$checkColor;
				if($tmp[6] == "1"){
					$checkColor = "greencheck";
				}else{
					$checkColor = "check";
				}
				$returnthis = $returnthis . "<p style='display:table;margin-left:auto;margin-right:auto;font-size:20px;'>" . courseName($username, $tmp[1]) . "\t" . $tmp[0] . "\t" . $tmp[3] . "\t" . $tmp[4] . " minutes  <img src='" . $checkColor . ".svg' style='width:20px; height:20px;' onClick='toggleComplete(" . $tmp[5] . ")' /></p>"; 
				$returnthis = $returnthis . "</div>";
			}
			$x++;
		}
		$returnthis = $returnthis . "<br />";
	}
	if(sizeof($coursenames) < 1){
		return " ";
	}
	return $returnthis;
}
function showCourseAssignments($username,$data){
	$filename = "../_userdata2/" . $username . "/assignments.txt";
	
	$coursenames = array();
	$endl = "/l/";
	$endi = "/i/";

	if(file_exists($filename)){
		$rawdata = file_get_contents($filename);
		
		$rawcourses = explode($endl, $rawdata);
		

		foreach($rawcourses as $tmpcourse){
		
			$tmp = explode($endi, $tmpcourse);
			if(isset($tmp[1]) && $tmp[1]==$data){
				array_push($coursenames, $tmp);
			}
		}
		$sorted = false;
		while($sorted == false){
			$sorted = true;
			for($x = 0; $x<sizeof($coursenames)+1;$x++){
				if(isset($coursenames[$x]) && isset($coursenames[$x+1])){
					$first = $coursenames[$x];
					$second = $coursenames[$x+1];
					$tmp = explode("/i/", $first);
					$tmp2 = explode("/i/", $second);
					if($tmp[1] > $tmp2[1]){
						$coursenames[$x] = $second;
						$coursenames[$x+1] = $first;
						$sorted = false;
					}
				}
			}			
		}
		$returnthis = "";
		$x = 1;
		foreach($coursenames as $tmpcourse){
			$tmp = explode("/i/", $tmpcourse);
			$returnthis = $returnthis . "<div class='course" . $x . "In' style='margin-top:5px;float:left;width:50%;'>";
			$returnthis = $returnthis . "<div id='courseH" . $x . "' style='height:24px;width:90%;margin-left:auto;margin-right:auto;padding-bottom:3px;'>";
			$returnthis = $returnthis . "<p style='display:table;margin-left:auto;margin-right:auto;font-size:20px;'>" . $tmp[0] . "</p>";
			$returnthis = $returnthis . "</div>";
			$returnthis = $returnthis . "</div>";
			
			$x++;
		}
		$returnthis = $returnthis . "<br />";
	}
	if(sizeof($coursenames) < 1){
		return " ";
	}
	return $returnthis;
}

if($command == "showCourses"){
	echo json_encode(showCourses($data, $username));
}else if($command=="writeCourses"){
	echo writeCourses($data, $username);
}else if($command=="showCal"){
	echo displayCal($data, $username);
}else if($command=="listCourses"){
	echo json_encode(listCourses($username));
}else if($command=="showPinnedCourses"){
	echo json_encode(showPinnedCourses($username,$data));
}else if($command=="deleteCourses"){
	echo json_encode(deleteCourses($data,$username));
}else if($command=="deleteAssignment"){
	echo json_encode(deleteWork($data,$username));
}else if($command=="courseOptions"){
	echo courseOptions($username);
}else if($command=="writeWork"){
	echo json_encode(writeWork($data,$username));
}else if($command=="showAllAssignments"){
	echo json_encode(showAllAssignments($username));
}else if($command=="toggleComplete"){
	echo json_encode(toggleComplete($username, $data));
}else if($command=="echoAssignments"){
	echo echoAssignment($data, $username);
}	
?>