<?php 

require 'config/config.php';

class DB
{
	public static $error = [];

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
		if(isset($_GET['cat_id']))
		{
			$id = $_GET['cat_id'];
		}

		$stmt = self::connect()->prepare('SELECT p.id, p.name, p.description, p.text, p.created_at, n.id, n.nav_name, s.status_name FROM posts p INNER JOIN navigates n ON p.category_id = n.id LEFT JOIN status s ON p.status_id = s.id WHERE n.id = :id ORDER BY p.created_at DESC');
		$stmt->execute([':id' => $id]);
		return $stmt->fetchAll();
	} 

	private function commenting()
	{
		if(isset($_POST['user_id']) && $_POST['user_id'] != '' && !empty($_POST['comment']) && $_POST['comment'] != '')
		{
			$user_id = $_POST['user_id'];
			$post_id = $_POST['post_id'];
			$comment = htmlspecialchars(trim($_POST['comment']));

			$stmt = self::connect()->prepare('INSERT INTO comments(user_id, comment, post_id) VALUES (:user_id, ":comment", :post_id');
			$stmt->bindValue([':user_id'=>$user_id]);
			$stmt->bindValue([':comment'=>$comment]);
			$stmt->bindValue([':post_id'=>$post_id]);
			$stmt->execute();
		}
	}

	public static function getEmail($email)
	{
		$stmt = self::connect()->prepare('SELECT * FROM users WHERE email = :email');
		$stmt->execute([':email'=>$email]);
		return $stmt->fetch();
	}

	public static function newUser(array $data)
	{

		$stmt = self::connect()->prepare('INSERT INTO users(user_name, email, password) VALUES(:user_name, :email, :password)');
		$stmt->bindValue(':user_name', $data['userName']);
		$stmt->bindValue(':email', $data['email']);
		$stmt->bindValue(':password', $data['password']);
		
		if($stmt->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public static function newComment(array $data)
	{
		$stmt = self::connect()->prepare('INSERT INTO comments(user_id, comment, post_id) VALUES (:user_id, :comment, :post_id)');
		$stmt->bindParam(':user_id', $data['user_id']);
		$stmt->bindParam(':comment', $data['comment']);
		$stmt->bindParam(':post_id', $data['post_id']);
		if($stmt->execute())
		{
			$_SESSION['success'] = "Комментарий успешно сохранен, спасибо за Ваш комментарий!";
		}
		else
		{
			$_SESSION['msg'] = 'Комментарий не был сохранен, попробуйте позже';
		}
	}

	public static function getComments($id)
	{
		$stmt = self::connect()->prepare('SELECT c.id, c.comment, c.updated_at, c.status_id, u.user_name, c.post_id FROM comments c LEFT JOIN users u ON c.user_id = u.id WHERE c.post_id = :id ORDER BY c.updated_at DESC');
		$stmt->execute([':id'=>$id]);
		return $stmt->fetchAll();
	}

	protected function getCountPosts()
	{
		$stmt = self::connect()->query('SELECT COUNT(*) FROM posts');
		return $stmt->fetchColumn();
	}

	public static function pagination()
	{
		$limit = 2;
		$total = self::getCountPosts();
		$pages = ceil($total/$limit);

		$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
				'options'=>array(
					'default'=>1,
					'min_range'=>1,
				),
			)));
		$offset = $page * $limit;
		$start = $offset + 1;
		$end = min(($offset + $limit), $total);
		$prevLink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page='.($page - 1).'" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&lsaquo;</span>';
		$nextLink = ($page < $pages) ? '<a href="?page='.($page + 1).'" title="Next page">&rsaquo;</a> <a href="'.$pages.'" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
		echo '<div id="paging"><p>', $prevLink, ' Page ', $page, ' of ', $pages, ' pages, displaying '. $start. '-'. $end. ' of '. $total. ' results '. $nextLink. ' </p></div>';
		$stmt = self::connect()->prepare('SELECT * FROM posts ORDER BY LIMIT ? OFFSET ?');
		$stmt->bindParam(1, $limit, PDO::PARAM_INT);
		$stmt->bindParam(2, $offset, PDO::PARAM_INT);
		$stmt->execute();

		if($stmt->rowCount() > 0)
		{
			$iterator = new IteratorIterator($stmt);

			foreach($iterator as $row)
			{
				echo '<p>'.$row['name'].'</p>';
			}
		}
		else
		{
			echo '<p>No results could be displayed</p>';
		}

	}

}