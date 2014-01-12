<?php

session_start();
function logout(){
	$_SESSION = array();
	session_destroy();
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
	
	
}

logout();

?>