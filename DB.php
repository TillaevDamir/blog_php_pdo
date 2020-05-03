<?php 

class DB
{
	private function connect()
	{
		$config = require 'config/db.php';

		return $db = new PDO('mysql: host='.$config['host'].'; dbname='.$config['dbname'].'', $config['user'], $config['pass'], $config['opt']);
	}

	public static function getNav()
	{
		$stmt = self::connect()->query('SELECT n.id, n.nav_name, s.status_name FROM navigates n INNER JOIN status s ON n.status_id = s.id');
		return $stmt->fetchAll();
	}

	public static function lastInsertPost()
	{
		$stmt = self::connect()->query('SELECT id, name, description FROM posts WHERE status_id=1 ORDER BY created_at DESC LIMIT 1');
		return $stmt->fetch();
	}

	public static function getTwoPost()
	{
		$stmt = self::connect()->query('SELECT p.id, p.name, p.description, p.created_at, n.nav_name, s.status_name FROM posts p INNER JOIN navigates n ON p.category_id = n.id LEFT JOIN status s ON p.status_id = s.id ORDER BY p.created_at DESC LIMIT 2');
		return $stmt->fetchAll();
	}

	public static function getAllPosts()
	{
		$stmt = self::connect()->query('SELECT p.id, p.name, p.description, p.text, p.created_at, n.nav_name, s.status_name FROM posts p INNER JOIN navigates n ON p.category_id = n.id LEFT JOIN status s ON p.status_id = s.id ORDER BY p.created_at DESC');
		return $stmt->fetchAll();
	}

	public static function getAboutInfo()
	{
		$stmt = self::connect()->query('SELECT text FROM about');
		return $stmt->fetch();
	}

	public static function getSinglePost()
	{
		if(isset($_GET['id']))
		{
			$id = $_GET['id'];
		}

		$stmt = self::connect()->prepare('SELECT p.id, p.name, p.description, p.text, p.created_at, n.nav_name, s.status_name FROM posts p INNER JOIN navigates n ON p.category_id = n.id LEFT JOIN status s ON p.status_id = s.id WHERE p.id = :id ORDER BY p.created_at DESC');
		$stmt->execute([':id' => $id]);
		return $stmt->fetchAll();
	}

	public static function getByCategory()
	{
		if(isset($_GET['id']))
		{
			$id = $_GET['id'];
		}

		$stmt = self::connect()->prepare('SELECT p.id, p.name, p.description, p.text, p.created_at, n.id, n.nav_name, s.status_name FROM posts p INNER JOIN navigates n ON p.category_id = n.id LEFT JOIN status s ON p.status_id = s.id WHERE n.id = :id ORDER BY p.created_at DESC');
		$stmt->execute([':id' => $id]);
		return $stmt->fetchAll();
	} 
}