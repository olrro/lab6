<?php

/*
=====================================================
 Настройки сайта
 -------------------------------------
 Файл: config.php
=====================================================
*/

if ( !isset( $_SESSION['logged_user'] ) ) {

  if ( isset( $_POST['login'] ) ) {

    if ( isset( $_POST["g-recaptcha-response"] ) ) {

      $params = [

        'secret' => $system['recaptcha']['secret_key'],
        'response' => $_POST["g-recaptcha-response"],
        'remoteip' => returnIP()

      ];

      $request = @file_get_contents( $system['recaptcha']['check'] . '?' . http_build_query( $params ) );

      if ( $request ) {

        $result = json_decode( $request, 1 );

        if ( !$result['success'] ) {
          $is_bot = 1;
        }

      }
      else {
        $is_bot = 1;
      }

    }
    else {
      $is_bot = 1;
    }

    if ( isset( $_POST['password'] ) AND isset( $_POST['repeat'] ) ) {

      if ( mb_strlen( $_POST['password'] ) > 50 OR mb_strlen( $_POST['password'] ) < 6 ) {
        $error = 1;
      }
      elseif ( mb_strlen( $_POST['repeat'] ) > 50 OR mb_strlen( $_POST['repeat'] ) < 6 ) {
        $error = 1;
      }
      elseif ( $_POST['password'] != $_POST['repeat'] ) {
        $error = 1;
      }

    }
    else {
      $error = 1;
    }

    if ( isset( $_POST['email'] ) ) {

      if ( filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) AND mb_strlen( $_POST['email'] ) < 256 AND mb_strlen( $_POST['email'] ) > 2 ) {

        $query = $database->prepare( 'SELECT * FROM users WHERE email = ?' );
        $query->execute( [ $_POST['email'] ] );

        if ( $row = $query->fetch() ) {
          $error = 1;
        }

      }
      else {
        $error = 1;
      }

    }
    else {
      $error = 1;
    }

    if ( isset( $_POST['login'] ) ) {

      if ( preg_match( '/^[A-Za-z0-9]+$/i', $_POST['login'] ) AND mb_strlen( $_POST['login'] ) < 26 AND mb_strlen( $_POST['login'] ) > 5 ) {

        $query = $database->prepare( 'SELECT * FROM users WHERE login = ?' );
        $query->execute( [ $_POST['login'] ] );

        if ( $row = $query->fetch() ) {
          $error = 1;
        }

      }
      else {
        $error = 1;
      }

    }
    else {
      $error = 1;
    }

    if ( !isset( $error ) AND !isset( $is_bot ) ) {

      $params = $system['user_data'] = [

        'login' => $_POST['login'],
        'email' => $_POST['email'],
        'password' => password_hash( $_POST['password'] , PASSWORD_DEFAULT )

      ];

      $query = $database->prepare( 'INSERT INTO users (login, password, email) VALUES (:login, :password, :email)' );
      $query->execute( $params );

      $_SESSION['logged_user'] = $database->lastInsertId();

      $tpl = new Template;

      $page = $tpl->load( 'register.success.tpl' )
      ->set( '{id}', '' )
      ->set( '{name}', '' )
      ->set( '{login}', $params['login'] )
      ->set( '{password}', '' )
      ->block( "'\\[social\\](.*?)\\[/social\\]'si", "" )
      ->compile();

    }
    else {

      if ( isset( $is_bot ) ) {

        $page = returnInformationBox(
          'Вы бот',
          'Наш сайт посчитал, что вы робот. Если это не так - свяжитесь с администратором. Перейти на <a href="/">главную</a> страницу',
          'fas fa-robot'
        );

      }
      else {

        $page = returnInformationBox(
          'Неудачно',
          'Регистрация не удалась. Пожалуйста, вернитесь <a href="/register">назад</a> и перепроверьте введенные данные',
          'fas fa-times-circle'
        );

      }

    }

  }
  else {

    $tpl = new Template;
    $page = $tpl->load( 'register.tpl' )->set( '{recaptcha-public}', $system['recaptcha']['public_key'] )->compile();

  }

}
else {

  $page = returnInformationBox(
    'Вы уже с нами',
    'Вы уже авторизованы на сайте. Перейти на <a href="/">главную</a> страницу',
    'fas fa-user-check'
  );

}


 ?>
