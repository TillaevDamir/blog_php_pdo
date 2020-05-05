<?php include 'Auth.php'; ?>
<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Пример на bootstrap 4: Пользовательская форма и дизайн для простой формы входа.">

    <title>Страница входа | Signin Template for Bootstrap</title>

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

      html,
      body {
        height: 100%;
      }

      body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
      }
      .form-signin .checkbox {
        font-weight: 400;
      }
      .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
      }
      .form-signin .form-control:focus {
        z-index: 2;
      }
      .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
      }
      .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

  </head>

  <body class="text-center">
    <div class="container">
      <div class="row">
        <form class="form-signin text-center" method="POST">
          <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
          <?php echo getErrors($errors);?>
          <label for="inputName" class="sr-only">Введите свое имя</label>
          <input type="text" name="user_name" id="inputName" class="form-control text-center" placeholder="User Name" value="<?= isset($_POST['user_name']) ? $_POST['user_name'] : '';?>" required autofocus>
          <label for="inputEmail" class="sr-only">Введите ваш электронный адрес</label>
          <input type="email" name="email" id="inputEmail" class="form-control text-center" placeholder="Email address" value="<?= isset($_POST['email']) ? $_POST['email'] : '';?>" required autofocus>
          <label for="inputPassword" class="sr-only">Пароль</label>
          <input type="password" name="password" id="inputPassword" class="form-control text-center" placeholder="Password" required>
          <label for="inputPassword2" class="sr-only">Повторите ваш пароль</label>
          <input type="password" name="password2" id="inputPassword2" class="form-control text-center" placeholder="Password" required>
          <button class="btn btn-lg btn-primary btn-block mb-3" name="signup" type="submit">Зарегистрироваться</button>
          <p><a href="login.php">Войти</a></p>
        </form>
      </div>
    </div>

</body>
</html>