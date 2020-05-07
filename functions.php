<?php 
require_once 'DB.php';

if(isset($_POST['save_comment']))
{
	if(empty($_POST['comment']))
	{
		$_SESSION['error'] = 'Комментарий отсутствует.'; 
	}
	if(empty($_POST['user_id']) && empty($_POST['post_id']))
	{
		$_SESSION['error'] = 'Вы не авторизованы';
	}
	if(!empty($_SESSION['error']))
	{
		header('Location: '.$_SERVER['REQUEST_URI']);exit;
	}
	else
	{
		$data['comment'] = htmlspecialchars(trim($_POST['comment']));
		$data['user_id'] = $_POST['user_id'];
		$data['post_id'] = $_POST['post_id'];

		DB::newComment($data);

		header('Location: '.$_SERVER['REQUEST_URI']);exit;
	}
}