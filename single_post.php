<?php require_once 'DB.php'; ?>
<!DOCTYPE html>

<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Пример на bootstrap 4: Блог - двухколоночный макет блога с пользовательской навигацией, заголовком и содержанием.">

    <title>Блог | Blog Template for Bootstrap</title>


    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">

  </head>

  <body>

    <div class="container">
  <header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
      <div class="col-4 pt-1">
        <a class="text-muted" href="#">Subscribe</a>
      </div>
      <div class="col-4 text-center">
        <a class="blog-header-logo text-dark" href="/myblog">Large</a>
      </div>
      <div class="col-4 d-flex justify-content-end align-items-center">
        <a class="text-muted" href="#" aria-label="Search">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"/><path d="M21 21l-5.2-5.2"/></svg>
        </a>
        <?php if(!empty($_SESSION['status'])):?>
        <a class="btn btn-sm btn-outline-secondary" href="logout.php">Выйти</a>
        <?php else: ?>
        <a class="btn btn-sm btn-outline-secondary" href="register.php">Войти</a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
<?php $nav = DB::getNav();
foreach($nav as $k=>$val):?>
	<?php if($val['status_name'] === 'enable'): ?>
      <a class="p-2 text-muted" href="index.php?cat_id=<?= $val['id']; ?>"><?= $val['nav_name']; ?></a>
  <?php endif; ?>
<?php endforeach; ?>
    </nav>
  </div>
  <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
    <div class="col-md-6 px-0">
    	<?php $lastPost = DB::lastInsertPost(); ?>
      <h1 class="display-4 font-italic"><?= $lastPost['name']; ?></h1>
      <p class="lead my-3"><?= $lastPost['description']; ?></p>
      <p class="lead mb-0"><a href="single_post.php?id=<?= $lastPost['id'];?>" class="text-white font-weight-bold">Continue reading...</a></p>
    </div>
  </div>

<?php $twoPost = DB::getTwoPost();?>
  <div class="row mb-2">
  	<?php foreach ($twoPost as $key => $value): ?>
  		<div class="col-md-6">
  		  <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
  		    <div class="col p-4 d-flex flex-column position-static">
  		      <strong class="d-inline-block mb-2 text-<?php if($key%2 == 0) {echo 'primary';} else {echo 'success';} ?>"><?= $value['nav_name']; ?></strong>
  		      <h3 class="mb-0"><?= $value['name']; ?></h3>
  		      <div class="mb-1 text-muted"><?php $data = explode(' ', $value['created_at']); $date = array_shift($data); $timestamp = explode('-', $date); $year = array_shift($timestamp); $month = array_shift($timestamp); $day = array_shift($timestamp); echo ' Month '.$month.' Day '.$day;?></div>
  		      <p class="card-text mb-auto"><?= mb_strimwidth($value['description'], 0, 100, '...'); ?></p>
  		      <a href="single_post.php?id=<?= $value['id'];?>" class="stretched-link">Continue reading...</a>
  		    </div>
  		  </div>
  		</div>
  	<?php endforeach ?>
  </div>
</div>


<?php $post = DB::getSinglePost(); ?>
<main role="main" class="container">
  <div class="row">
    <div class="col-md-8 blog-main">
      <h3 class="pb-4 mb-4 font-italic border-bottom">
        From the Firehose
      </h3>
      <?php if(!empty($post)): ?>
<?php foreach($post as $mypost): ?>
      <div class="blog-post">
      	<?php if($mypost['status_name'] === 'enable'): ?>
        <h2 class="blog-post-title"><?= $mypost['name']; ?></h2>
        <p class="blog-post-meta"><?php $data = explode(' ', $mypost['created_at']); $date = array_shift($data); $timestamp = explode('-', $date); $year = array_shift($timestamp); $month = array_shift($timestamp); $day = array_shift($timestamp); echo ' Month '.$month.' Day '.$day;?></p>

        <p><?= $mypost['text'];?> </p>
    <?php endif; ?>
      </div><!-- /.blog-post -->
<?php endforeach; ?>

<?php if(!empty($_SESSION['status'])): ?>
      <div class="col-md-12 mt-5 text-center">
        <form method="POST">
          <div class="form-row align-items-center">
            <div class="col-md-10">
              <label class="sr-only" for="inlineFormInputGroup">Имя пользователя</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text"><?= !empty($_SESSION['status']) ? $_SESSION['status']['name'] : 'Comment'; ?></div>
                </div>
                <input type="hidden" name="post_id" value="<?= $post[0]['id']; ?>">
                <input type="hidden" name="user_id" value="<?= !empty($_SESSION['status']) ? $_SESSION['status']['id'] : ''; ?>">
                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Комментарий">
              </div>
            </div>
            <div class="col-auto">
              <button type="submit" class="btn btn-primary mb-2">Отправить</button>
            </div>
          </div>
        </form>
      </div>
<?php endif; ?>
      <?php else: ?>
      <h2>Post not exists</h2>
<?php endif; ?>
      <div class="col-md-12 mt-3 text-secondary" id="comments">
        <div class="col-md-4 pt-3">
          <p class="card-title">User Name</p>    
        </div>
        <div class="col-md-12">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi </p>
        </div>
        <div class="col-md-12">
          <p class="text-right">2020.05.12 15:12</p>
        </div>
        <div class="col-md-4 pt-3">
          <p class="card-title">User Name</p>    
        </div>
        <div class="col-md-12">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi </p>
        </div>
        <div class="col-md-12">
          <p class="text-right">2020.05.12 15:12</p>
        </div>
      </div>

    </div><!-- /.blog-main -->
<?php $about = DB::getAboutInfo(); ?>
    <aside class="col-md-4 blog-sidebar">
      <div class="p-4 mb-3 bg-light rounded">
        <h4 class="font-italic">About</h4>
        <p class="mb-0"><?= $about['text']; ?></p>
      </div>

      <div class="p-4">
        <h4 class="font-italic">Archives</h4>
        <ol class="list-unstyled mb-0">
          <li><a href="#">March 2014</a></li>
          <li><a href="#">February 2014</a></li>
          <li><a href="#">January 2014</a></li>
          <li><a href="#">December 2013</a></li>
          <li><a href="#">November 2013</a></li>
          <li><a href="#">October 2013</a></li>
          <li><a href="#">September 2013</a></li>
          <li><a href="#">August 2013</a></li>
          <li><a href="#">July 2013</a></li>
          <li><a href="#">June 2013</a></li>
          <li><a href="#">May 2013</a></li>
          <li><a href="#">April 2013</a></li>
        </ol>
      </div>

      <div class="p-4">
        <h4 class="font-italic">Elsewhere</h4>
        <ol class="list-unstyled">
          <li><a href="#">GitHub</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Facebook</a></li>
        </ol>
      </div>
    </aside><!-- /.blog-sidebar -->

  </div><!-- /.row -->

</main><!-- /.container -->


<footer class="blog-footer container mt-5 text-center">
  <p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
  <p>
    <a href="#">Back to top</a>
  </p>
</footer>
</body>
</html>
