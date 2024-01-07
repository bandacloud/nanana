<?php
if(!isset($_SESSION))
{
	session_start();
}
function loggedin()
{
	if(isset($_SESSION['uid']))
	{
		if(!empty($_SESSION['uid']))
		{	
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>