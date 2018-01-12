<?php 
	session_start();
	echo $_SESSION['value'];
	$cde = $_POST['vdcodetel'];
	$text = $_POST['tel'];
	$wu = $_POST['username'];
	
	
	$url = "http://ylzb.gensee.com/webcast/site/entry/join-94371a4dc27f44a88e5074ad75a459ff?nickName=";

    if( $_POST['vdcodetel']==$_SESSION['value']&&$_SESSION['value']<>'')
	{
		 echo "<script language='javascript' type='text/javascript'>";  
		 echo "window.location.href='$url$wu$text'";  
		 echo "</script>";
    }else
	{
		 echo "<script language='javascript' type='text/javascript'>";  
		 echo "window.location.href='webcast.html'";  
		 echo "</script>";
	}
?>

