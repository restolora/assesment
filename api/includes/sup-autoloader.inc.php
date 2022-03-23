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
function getTotalVat($value){
	$out = $value*.12;
	$out = $out + $value;
	return $out;
}
function vatAmount($value){
	$out = $value * .12;
	return $out;
}
function vatable($value){
	$vatAmount = $value * .12;
	$vatable = $value - $vatAmount;
	return $vatable;
}
?>