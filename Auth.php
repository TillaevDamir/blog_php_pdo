<?php
require 'DB.php'; 

$errors = [];

if(isset($_POST['signup']))
{
	if(empty($_POST['user_name']) && $_POST['user_name'] == '')
	{
		$errors[] = "Enter a name";
	}
	if(empty($_POST['email']) && $_POST['email'] == '')
	{
		$errors[] = "Enter email";
	}
	if(empty($_POST['password']) && $_POST['password'] == '')
	{
		$errors[] = 'Enter a password';
	}
	if($_POST['password'] !== $_POST['password2'])
	{
		$errors[] = "Passwords is incorrect";
	}
	if(count($errors) > 0)
	{
		header('Location: register.php');
	}
	else
	{
		$data['userName'] = htmlspecialchars(trim($_POST['user_name']));
		$data['email'] = htmlspecialchars(trim($_POST['email']));
		$data['password'] = password_hash(htmlspecialchars(trim($_POST['password'])), PASSWORD_DEFAULT);

		if(DB::newUser($data))
		{
			$_SESSION['msg'] = "You are registered success!";
			header('Location: login.php'); exit;
		}
		else
		{
			$errors = "Something went wrong";
			header('Location: login.php'); exit;
		}

	}
}
else
{
	debug($_POST);
	// header('Location: login.php');
}

function getErrors($errors)
{
	if(!empty($errors))
	{
		foreach($errors as $k=>$error)
		{
			echo '<h3 class="bg-danger">'.$k.'. '.$error.'</h3>';
		}
	}
}