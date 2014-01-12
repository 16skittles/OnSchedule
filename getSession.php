<?php
	session_start();
	
	if(!isset($_SESSION['valid'])){
		$_SESSION['valid'] = 0;
	}
	
	if(!$_SESSION['valid']){
		$loggedIn = 0;
	}else{
		$loggedIn = 1;
	}
	
	if($loggedIn && isset($_SESSION['username'])){
		$username = $_SESSION['username'];
	}else{
		$username = "null";
	}
	
	$dir = "../_userdata2/" . $username . "/";
	if(!is_dir($dir)){
        //mkdir($dir);
		$setup = 1;
    }else{
		$setup = 0;
	}
	
    $session = array(
        'loggedin' => $loggedIn,
        'username' => $username,
		'setup' => $setup
     );


    echo json_encode($session);
?>