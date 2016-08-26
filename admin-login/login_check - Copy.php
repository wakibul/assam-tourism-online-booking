<?php
ob_start();
session_start();
include("../include/config.php");

$url="http://";
$url.= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
$urlregex = "/^".
  "(?:http:\\/\\/)?".  // Look for http://, but make it optional.
  "(?:[A-Z0-9][A-Z0-9_-]*(?:\\.[A-Z0-9][A-Z0-9_-]*))". // Server name
  "(?:\\d+)?".         // Optional port number
  "(?:\\/\\.*)?/i";
if(filter_var($url, FILTER_VALIDATE_URL) || (preg_match($urlregex, $url)))
{
} 
else { 
	header("location: index.php");
}
$errmsg_arr = array();	
$errflag = false;	
if(isset($_POST['txtuser']))
	$user = htmlentities(strip_tags($_POST['txtuser']));
if(isset($_POST['txtpass']))
	$pass = htmlentities(strip_tags($_POST['txtpass']));
else
	$pass = "";
if(isset($_POST['selCity']))
	$selCity = htmlentities(strip_tags($_POST['selCity']));
else
	$selCity = "";
$salt=$_SESSION['nonce'];
$user1=array("$user");
$symb1= array("`","~","!","#","$","%","^","&","*","(",")","+","=","{","}","[","]","|",":",";","\"","'","<",">",",","?","\\");
foreach($user1 AS $user2){
	foreach($symb1 AS $try1){
		$pos1 = strpos($user2,$try1);
		if($pos1 !== false){
			echo 'Special charecters are not allowed.';
			exit();
}}} 
?>
<?php 
$regdate= date("Y/m/d");
$today = date('Y-m-d');
$ip = $_SERVER['REMOTE_ADDR'];
$hostaddress="";	
if (($user!="") && ($pass!="") && ($selCity!="")) {
	$stat = 'failed';
	$rs_stime = "select count(*) as tlock from atbooking_logintrack where user = :user and status = :f and date=:t";
	$qry = $pdo->prepare($rs_stime);
	$qry->bindParam(':user', $user, PDO::PARAM_STR);
	$qry->bindParam(':f', $stat, PDO::PARAM_STR);
	$qry->bindParam(':t', $today, PDO::PARAM_STR);
	$qry->execute();
	$row = $qry->fetch(PDO::FETCH_ASSOC);
    if($row['tlock'] >= '0')
	{
		$rs_ltime = "select ltime from atbooking_logintrack where user = :user and status = :f and date=:t order by id desc limit 1";
		$qry2 = $pdo->prepare($rs_ltime);
		$qry2->bindParam(':user', $user, PDO::PARAM_STR);
		$qry2->bindParam(':f', $stat, PDO::PARAM_STR);
		$qry2->bindParam(':t', $today, PDO::PARAM_STR);
		$qry2->execute();
		$row2 = $qry2->fetch(PDO::FETCH_ASSOC);
		if(time()-$row2['ltime'] < 60*60){
			  echo  'Your account has been locked due to incorrect login attempts. Please try after 1 hour';
			   session_write_close();
			   exit();
		}
    }
	
	$sql= "Select * from atbooking_login where BINARY UserName = :user and UserStatus=1 and Location = :l"; 
	$qry3 = $pdo->prepare($sql);
	$qry3->bindParam(':user', $user, PDO::PARAM_STR);
	$qry3->bindParam(':l', $selCity, PDO::PARAM_INT);	
	$qry3->execute();
	$rCount = $qry3->rowCount();
	$bt=0;
	if ($rCount>0)
	{
		$row3 = $qry3->fetch(PDO::FETCH_ASSOC);
		$temp=$row3['UserPwd'].$salt;
		//echo $pass." == ".md5($temp);
			if (($user == $row3['UserName']) && ($pass == md5($temp)))
			{
				if (!isset($_SESSION)) {
					session_start();
					session_regenerate_id (true);	
				}
				echo "waki";	
				$UserID=$row3['UserID']; 
				$_SESSION['UserID'] = $row3['UserID'];	
				$_SESSION['UserName'] = $row3['UserName'];			
				$_SESSION['UserGrp'] = $row3['UserGrp'];
				$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
				$stamp = time();
				$ckey = GenKey();
				mysql_query("update tbllogin set `ctime`='$stamp',`ckey`='$ckey',stime='$stamp' where UserID='".$UserID."'") or die("Invalid Request");
				setcookie("user_id", $_SESSION['UserID'], time()+60*60*24, "/",'',httpOnly);
				setcookie("user_key", sha1($ckey), time()+60*60*24, "/",'',httpOnly);
				setcookie("user_name",$_SESSION['UserName'], time()+60*60*24, "/",'',httpOnly);
				mysql_query("INSERT INTO tbllogintrack(user,date,ip,atmpt,status,ltime,action) VALUES('".$_SESSION['UserName']."','$today','$hostaddress','0','success','$stamp','Logged In')") or die("Invalid Request");
				$bt=1;
			}
			else
			{
				echo "Incorrect username & password";
			}
		
	}
	else
			{
				echo "Incorrect username & password";
			}
	
	
	/*if ($bt == 0){
		$ltime = time();
		mysql_query("INSERT INTO tbllogintrack(user,date,ip,atmpt,status,ltime,action) VALUES('".$user."','$today','$hostaddress','1','failed','$ltime','Login Failed')") or die("Invalid Request");
				
		$errmsg_arr[] = 'Incorrect User name and Password';
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: index.php");
		exit(); 
	}*/
}
?>
<?php ob_end_flush();?>