<?php 
	session_start();
	echo $_SESSION['value'];
	$cde = $_POST['vdcodetel'];
	$text = $_POST['tel'];
	$wu = $_POST['username'];
	
	
	$url = "http://ylzb.gensee.com/webcast/site/entry/join-96828e487f5e46aca95d7ffdee12b078?nickName=";

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

