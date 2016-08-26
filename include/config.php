<?php
$dsn 		= 'mysql: host=localhost; dbname=atbooking';
$user 		= 'root';
$password 	= '';
try {
$pdo = new PDO($dsn, $user, $password);
$pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
//functions
function GetYearYYYYMMDD($val)
{
	$dateMArray = explode("-", $val);
	$val = $dateMArray[2]."-".$dateMArray[1]."-".$dateMArray[0];
	return $val;
}

function getDateDDMMYYYY($val)
{
	$myDateArray = explode("-", $val);
	$val = ($myDateArray[2]."-".$myDateArray[1]."-".$myDateArray[0]);
	return $val;
}

function GenKey($length = 8)
{
  $password = "";
  $possible = "0123456789abcdefghijkmnopqrstuvwxyz"; 
   $i = 0; 
   while ($i < $length) { 
     $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
     if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }
   }
   return $password;
}
?>