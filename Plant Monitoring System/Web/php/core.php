<?php
if(!isset($_SESSION))
{
	session_start();
}
function loggedin()
{
	if(isset($_COOKIE['uid']))
	{
		if(!empty($_COOKIE['uid']))
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