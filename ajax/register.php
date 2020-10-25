<?php

/*
=====================================================
 Проверка регистрационных данных [AJAX]
 -------------------------------------
 Файл: register.php
=====================================================
*/

if ( !isset( $_REQUEST['login'] ) AND !isset( $_REQUEST['email'] ) ) {

  header( 'HTTP/1.1 403 Forbidden' );
  header( 'Location: /' );

  exit();

}

define( 'ROOT_DIR', substr( dirname(  __FILE__ ), 0, -5 ) );

# Подключаем все требуемые файлы
require ROOT_DIR . '/config/db.php';

mb_internal_encoding( 'UTF-8' );

if ( isset( $_REQUEST['login'] ) ) {

  $query = $database->prepare( 'SELECT * FROM users WHERE login = ?' );
  $query->execute( [ $_REQUEST['login'] ] );

  if ( $row = $query->fetch() OR !preg_match( '/^[A-Za-z0-9]+$/i', $_REQUEST['login'] ) OR mb_strlen( $_REQUEST['login'] ) < 6 OR mb_strlen( $_REQUEST['login'] ) > 25 ) {
    exit( json_encode( [ 'status' => 0 ]) );
  }

  exit( json_encode( [ 'status' => 1 ]) );

}
elseif ( isset( $_REQUEST['email'] ) ) {

  $query = $database->prepare( 'SELECT * FROM users WHERE email = ?' );
  $query->execute( [ $_REQUEST['email'] ] );

  if ( $row = $query->fetch() OR !filter_var( $_REQUEST['email'], FILTER_VALIDATE_EMAIL ) OR mb_strlen( $_REQUEST['email'] ) < 3 OR mb_strlen( $_REQUEST['email'] ) > 255 ) {
    exit( json_encode( [ 'status' => 0 ]) );
  }

  exit( json_encode( [ 'status' => 1 ]) );

}


 ?>
