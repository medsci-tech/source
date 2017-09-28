<?php 
	session_start();
	echo $_SESSION['value'];
	$cde = $_POST['vdcodetel'];
	$text = $_POST['tel'];
	$wu = $_POST['username'];
	
	
	$url = "http://ylzb.gensee.com/webcast/site/entry/join-327794b05ff94e9b98ae17d36d5f97fb?nickName=";

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

