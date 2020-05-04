<?php require 'Auth.php'; ?>
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
        <form class="form-signin text-center" method="POST" action="Auth.php">
          <h1 class="h3 mb-3 font-weight-normal">Зарегистрироваться</h1>
          <?php debug($errors);?>
          <label for="inputEmail" class="sr-only">Введите свое имя</label>
          <input type="text" name="user_name" id="inputEmail" class="form-control text-center" placeholder="User Name" required autofocus>
          <label for="inputEmail" class="sr-only">Введите ваш электронный адрес</label>
          <input type="email" name="email" id="inputEmail" class="form-control text-center" placeholder="Email address" required autofocus>
          <label for="inputPassword" class="sr-only">Пароль</label>
          <input type="password" name="password" id="inputPassword" class="form-control text-center" placeholder="Password" required>
          <label for="inputPassword" class="sr-only">Повторите ваш пароль</label>
          <input type="password" name="password2" id="inputPassword" class="form-control text-center" placeholder="Password" required>
          <button class="btn btn-lg btn-primary btn-block" name="signup" value="signup" type="submit">Войти</button>
        </form>
      </div>
    </div>

</body>
</html>