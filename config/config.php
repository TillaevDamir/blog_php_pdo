<?php 

session_start();

function debug($val)
{
	echo "<pre>";
	var_dump($val);
	echo "</pre>";
}