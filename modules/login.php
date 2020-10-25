<?php

/*
=====================================================
 Страница авторизации
 -------------------------------------
 Файл: login.php
=====================================================
*/

if ( !isset( $_SESSION['logged_user'] ) ) {

  # Если пользователь хочет авторизоваться
  if ( isset( $_POST['login'] ) AND isset( $_POST['password'] ) ) {

    # Ищем пользователя в базе
    $query = $database->prepare( 'SELECT * FROM users WHERE login = ? OR email = ?' );
    $query->execute( [ $_POST['login'], $_POST['login'] ] );

    if ( $row = $query->fetch() ) {

      if ( password_verify( $_POST['password'], $row['password'] ) ) {

        # Успешная авторизация - редирект на главную страницу
        $_SESSION['logged_user'] = $row['id'];

        header('Location: /');
        exit();

      }
      else {

        $page = returnInformationBox(
          'Неудачный вход',
          'Такого пользователя не существует. Перейти на <a href="/">главную</a> страницу',
          'fas fa-times-circle'
        );

      }

    }
    else {

      $page = returnInformationBox(
        'Неудачный вход',
        'Похоже что вы ввели неправильный логин или пароль. Перейти на <a href="/">главную</a> страницу',
        'fas fa-times-circle'
      );

    }

  }
  elseif( isset( $_GET['code'] ) ) {

      $params = [

        'client_id' => $system['vk']['app_id'], 'display' => 'page', 'redirect_uri' => $system['url'] . 'login',
        'client_secret' => $system['vk']['secret_key'],
        'code' => $_GET['code'],

      ];

      $request = @file_get_contents( $system['vk']['oauth_url'] . '?' . http_build_query( $params ) );

      if ( $request ) {

        $results = json_decode( $request, 1 );

        if ( isset( $results['user_id'] ) AND isset( $results['access_token'] ) ) {

          $profile = [

            'social' => intval( $results['user_id'] ),
            'password' => substr( str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789" ), 0, 15 )

          ];

          if ( isset( $results['email'] ) ) {
            $profile['email'] = $results['email'];
          }
          else {
            $profile['email'] = '';
          }

          $params = [

            'user_id' => $results['user_id'], 'access_token' => $results['access_token'],
            'fields' => 'first_name,last_name',
            'v' => '5.52'

          ];

          $request = @file_get_contents( $system['vk']['info_url'] . '?' . http_build_query( $params ) );

          if ( $request ) {

            $results = json_decode( $request, 1 );
            $results = $results['response'][0];

            if ( isset( $results['first_name'] ) AND isset( $results['last_name'] ) ) {
              $profile['name'] = $results['first_name'] . ' ' . $results['last_name'];
            }

          }

        }

      }

      if ( isset( $profile['social'] ) AND isset( $profile['name'] ) ) {

          $query = $database->prepare( 'SELECT * FROM users WHERE social = :social' );
          $query->execute( [ $profile['social'] ] );

          if ( !$row = $query->fetch() ) {

            if ( !empty( $profile['email'] ) ) {

              $query = $database->prepare( 'SELECT * FROM users WHERE email = ?' );
              $query->execute( [ $profile['email'] ] );

              if ( $row = $query->fetch() ) {
                $error = 1;
              }

            }

            if ( !isset( $error ) ) {

              while ( 1 ) {

                $profile['login'] = returnNickname();

                $query = $database->prepare( 'SELECT * FROM users WHERE login = ?' );
                $query->execute( [ $profile['login'] ] );

                if ( !$row = $query->fetch() ) {
                  break;
                }

              }

              #Генерируем страницу с приветствием
              $system['user_data'] = $profile;

              $tpl = new Template;

              $page = $tpl->load( 'register.success.tpl' )
              ->set( '{id}', $profile['social'] )
              ->set( '{name}', $profile['name'] )
              ->set( '{login}', $profile['login'] )
              ->set( '{password}', $profile['password'] )
              ->set( '[social]', '' )
              ->set( '[/social]', '' )->compile();

              $profile['password'] = password_hash( $profile['password'], PASSWORD_DEFAULT );

              $query = $database->prepare( 'INSERT INTO users (login, password, name, email, social) VALUES (:login, :password, :name, :email, :social)' );
              $query->execute( $profile );

              $_SESSION['logged_user'] = $database->lastInsertId();

            }
            else {

              $page = returnInformationBox(
                'Ошибка',
                'С таким адресом электронной почты уже зарегистрирован пользователь. Повторная регистрация невозможна. Пожалуйста, попробуйте позже. Вернуться <a href="/login">назад</a>',
                'fas fa-times-circle'
              );

            }

          }
          else {

            # Успешная авторизация - редирект на главную страницу
            $_SESSION['logged_user'] = $row['id'] ;

            header('Location: /');
            exit();

          }

      }
      else {

        $page = returnInformationBox(
          'Вход неудался',
          'Произошла ошибка на сервере. Пожалуйста, попробуйте позже. Вернуться <a href="/login">назад</a>',
          'fas fa-times-circle'
        );

      }

  }
  else {

    $params = [

      'client_id' => $system['vk']['app_id'],
      'display' => 'page',
      'redirect_uri' =>  $system['url'] . 'login',
      'response_type' => 'code',
      'scope' => 'email'

    ];

    # Выводит форму авторизации
    $tpl = new Template;

    $page = $tpl->load('login.tpl')
    ->set( '{vk-auth}', $system['vk']['app_url'] . '?' . http_build_query( $params ) )
    ->compile();

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
