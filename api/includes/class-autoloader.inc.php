<?php 

spl_autoload_register('myAutoLoader');

function myAutoLoader ($className){
	$path = "./class/";
	$extension = ".class.php";
	$fileName = $path . $className . $extension;

	if(!file_exists($fileName)){
		return false;
	}
	include_once $path . $className . $extension;
}
    // $user_ID = "";
    // if(isset($_SESSION['user_ID'])){
    //     $user_ID = $_SESSION['user_ID'];
    // }else{
    //     $user_ID = "0";
    // }

?>