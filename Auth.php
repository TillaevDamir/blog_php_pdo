<?php
include 'DB.php'; 

$errors = [];

if(isset($_POST['signup']))
{
	if(empty($_POST['user_name']) && $_POST['user_name'] == '')
	{
		$errors[] = "Введите ваше имя!";
	}
	if(empty($_POST['email']) && $_POST['email'] == '')
	{
		$errors[] = "Введите ваш email";
	}
	if(empty($_POST['password']) && $_POST['password'] == '')
	{
		$errors[] = 'Введите пароль';
	}
	if($_POST['password'] !== $_POST['password2'])
	{
		$errors[] = "Пароли не совпадают";
	}
	if(count($errors) == 0)
	{
		$data['userName'] = htmlspecialchars(trim($_POST['user_name']));
		$data['email'] = htmlspecialchars(trim($_POST['email']));
		$data['password'] = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

		if(DB::getEmail($data['email']))
		{
			$errors[] = "Пользователь с таким emailом существует.";
		}

		elseif(DB::newUser($data))
		{
			$_SESSION['msg'] = "Вы успешно зарегистрировались!";
			header('Location: login.php');
		}
		else
		{
			$errors[] = "Регистрация не удалась!";
			return $errors; exit;
		}
	}
	else
	{
		return $errors; exit;
	}
}

if(isset($_POST['login']))
{
	if(!isset($_POST['email']) && $_POST['email'] == '')
	{
		$errors[] = "Введите email";
	}
	if(!isset($_POST['password']) && $_POST['password'] == '')
	{
		$errors[] = 'Введите пароль';
	}
	if(!DB::getEmail(trim($_POST['email'])))
	{
		$errors[] = "Пользователя не существует";	
	}
	if(!password_verify($_POST['password'], DB::getEmail(trim($_POST['email']))['password']))
	{
		$errors[] = "Email или пароль не верные";
	}
	if(count($errors) > 0)
	{
		return $errors;
	}
	else
	{
		$email = trim($_POST['email']);
		$user = DB::getEmail($email);
		$_SESSION['status'] = [
			'id'=>$user['id'], 
			'name'=>$user['user_name'], 
			'email'=>$user['email'], 
			'status'=>$user['status'],
		];
		header('Location: index.php');
	}
}

function getErrors($errors)
{
	if(!empty($errors))
	{
		foreach($errors as $k=>$error)
		{
			$k++;
			return '<h4 class="text-danger">'.$k.'. '.$error.'</h4>';
		}
	}
}

function getMsg()
{
	if(!empty($_SESSION['msg']))
	{
		return '<h4 class="text-success">'.$_SESSION['msg'].'</h4>';
	}
}